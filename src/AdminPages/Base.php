<?php

namespace My\Plugin\AdminPages;

class Base
{
    protected $parent_slug   = '';
    protected $page_title    = '';
    protected $menu_title    = '';
    protected $capability    = '';
    protected $menu_slug     = '';
    protected $position      = '';
    protected $option_name   = '';
    protected $submit_button = '';
    protected $page_hook     = '';

    protected $sections = [];
    protected $fields   = [];

    /**
     * Construct
     *
     * @param string $id
     * @param string $title
     * @param array  $args
     */
    public function __construct($id, $title, $args = [])
    {
        $args = wp_parse_args(
            $args,
            [
                'parent_slug'   => 'options-general.php',
                'page_title'    => $title,
                'menu_title'    => $title,
                'capability'    => 'manage_options',
                'menu_slug'     => "my_plugin_{$id}_options_page",
                'position'      => null,
                'option_name'   => "my_plugin_{$id}_options",
                'submit_button' => __('Update', 'my-plugin'),
            ]
        );

        $this->parent_slug   = $args['parent_slug'];
        $this->page_title    = $args['page_title'];
        $this->menu_title    = $args['menu_title'];
        $this->capability    = $args['capability'];
        $this->menu_slug     = $args['menu_slug'];
        $this->position      = $args['position'];
        $this->option_name   = $args['option_name'];
        $this->submit_button = $args['submit_button'];

        add_action('admin_init', [$this, 'adminInit']);
        add_action('admin_menu', [$this, 'addMenuPage']);
        add_action('admin_enqueue_scripts', [$this, 'maybeEnqueueAssets']);
    }

    /**
     * Get options
     *
     * @return array
     */
    public function getOptions()
    {
        return get_option($this->option_name, $this->getDefaultOptions());
    }

    /**
     * Get option
     *
     * @param string $name
     *
     * @return mixed
     */
    public function getOption($name)
    {
        $options = $this->getOptions();

        if (isset($options[$name])) {
            return $options[$name];
        }

        return null;
    }

    /**
     * Get default options
     *
     * @return array
     */
    public function getDefaultOptions()
    {
        return wp_list_pluck($this->fields, 'default_value', 'name');
    }

    /**
     * Add section
     */
    public function addSection($id, $title, $callback, $args = [])
    {
        $this->sections[$id] = compact('id', 'title', 'callback', 'args');
    }

    /**
     * Add section
     */
    public function addField($args)
    {
        $field = wp_parse_args(
            $args,
            [
                'name'          => '',
                'title'         => __('Untitled', 'my-plugin'),
                'type'          => 'text',
                'default_value' => null,
                'section'       => 'default',
                'description'   => '',
            ]
        );

        $this->fields[$field['name']] = $field;
    }

    /**
     * Admin init
     *
     * @return void
     */
    public function adminInit()
    {
        register_setting($this->menu_slug, $this->option_name, [$this, 'sanitizeOptions']);

        foreach ($this->sections as $section) {
            add_settings_section($section['id'], $section['title'], $section['callback'], $this->menu_slug, $section['args']);
        }

        foreach ($this->fields as $field) {
            $field['label_for'] = "{$this->menu_slug}-{$field['name']}";
            add_settings_field($field['name'], $field['title'], [$this, 'renderField'], $this->menu_slug, $field['section'], $field);
        }
    }

    /**
     * Render field
     *
     * @param array $field
     *
     * @return void
     */
    public function renderField($field)
    {
        $field['value'] = $this->getOption($field['name']);
        $field['id']    = "{$this->menu_slug}-{$field['name']}";
        $field['name']  = "{$this->option_name}[{$field['name']}]";

        do_action('my_plugin_render_field/type=' . $field['type'], $field);

        if ($field['description']) {
            printf('<p class="description">%s</p>', esc_html($field['description']));
        }
    }

    /**
     * Add menu page
     *
     * @return void
     */
    public function addMenuPage()
    {
        if ($this->parent_slug) {
            $this->page_hook = add_submenu_page($this->parent_slug, $this->page_title, $this->menu_title, $this->capability, $this->menu_slug, [$this, 'renderPage'], $this->position);
        } else {
            $this->page_hook = add_menu_page($this->page_title, $this->menu_title, $this->capability, $this->menu_slug, [$this, 'renderPage'], $this->position);
        }
    }

    /**
     * Render page
     *
     * @return void
     */
    public function renderPage()
    {
        ?>

        <div class="wrap">

            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

            <form action="options.php" method="post">

                <?php

                settings_fields($this->menu_slug);
                do_settings_sections($this->menu_slug);

                if ($this->submit_button) {
                    echo submit_button($this->submit_button);
                }

                ?>

            </form>

        </div>

        <?php
    }

    /**
     * Sanitize options
     *
     * @param array $input
     *
     * @return array
     */
    public function sanitizeOptions($input)
    {
        foreach ($input as $name => $value) {
            $field = isset($this->fields[$name]) ? $this->fields[$name] : null;

            if ($field) {
                $value = apply_filters('my_plugin_sanitize_field_value/type=' . $field['type'], $value, $field);
            }

            $input[$name] = $value;
        }

        return $input;
    }

    /**
     * Maybe Enqueue assets
     *
     * @return void
     */
    public function maybeEnqueueAssets()
    {
        $screen = get_current_screen();

        if ($screen->id != $this->page_hook) {
            return;
        }

        $this->enqueueAssets();
    }

    /**
     * Enqueue assets
     *
     * @return void
     */
    public function enqueueAssets()
    {
        wp_enqueue_script('wp-tinymce');
        wp_enqueue_script('my-plugin-admin', plugins_url('admin.js', MY_PLUGIN_FILE), ['jquery'], false, true);
    }
}
