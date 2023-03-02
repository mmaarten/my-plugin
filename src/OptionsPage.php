<?php

namespace My\Plugin;

class OptionsPage
{
    /**
     * Construct
     *
     * @param $id    string
     * @param $title string
     * @param $args  array
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
                'menu_slug'     => "my_{$id}_options_page",
                'position'      => null,
                'option_name'   => "my_{$id}_options",
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
        add_action('admin_menu', [$this, 'adminMenu']);
    }

    /**
     * Admin init
     *
     * @return void
     */
    public function adminInit()
    {
        register_setting($this->menu_slug, $this->option_name, [$this, 'sanitizeInput']);
    }

    /**
     * Admin Menu
     *
     * @return void
     */
    public function adminMenu()
    {
        if ($this->parent_slug) {
            add_submenu_page($this->parent_slug, $this->page_title, $this->menu_title, $this->capability, $this->menu_slug, [$this, 'render'], $this->position);
        } else {
            add_menu_page($this->page_title, $this->menu_title, $this->capability, $this->menu_slug, [$this, 'render'], $this->position);
        }
    }

    /**
     * Render
     *
     * @return void
     */
    public function render()
    {
        ?>

        <div class="wrap">

            <h1><?php echo get_admin_page_title(); ?></h1>

            <?php settings_fields($this->menu_slug); ?>
            <?php do_settings_sections($this->menu_slug); ?>

            <?php

            if ($this->submit_button) {
                submit_button($this->submit_button);
            }

            ?>

        </div>

        <?php
    }

    /**
     * Sanitize input
     *
     * @param $input array
     *
     * @return void
     */
    public function sanitizeInput($input)
    {
        return $input;
    }
}

