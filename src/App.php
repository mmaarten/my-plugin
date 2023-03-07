<?php

namespace My\Plugin;

/**
 * Main application
 */
class App
{
    static private $_instance = null;

    /**
     * Get instance
     *
     * @return App
     */
    static public function getInstance()
    {
        if (! self::$_instance) {
            self::$_instance = new App();
        }

        return self::$_instance;
    }

    protected $is_initialized = false;

    /**
     * Construct
     *
     * @return void
     */
    private final function __construct()
    {

    }
    /**
     * Initialize
     *
     * @return void
     */
    public function init()
    {
        if ($this->is_initialized) {
            return;
        }

        add_action('init', [$this, 'loadTextdomain']);

        $field_types = [
            'Text',
            'Textarea',
            'Number',
            'Editor',
            'Select',
        ];

        foreach ($field_types as $field_type) {
            $class = "\My\Plugin\Fields\\$field_type";
            new $class();
        }

        $options_page = new OptionsPage('test', 'Test');
        $options_page->addSection('default', '', null);

        $options_page->addField(
            [
                'name'  => 'textfield',
                'title' => 'Textfield',
                'type'  => 'text',
            ]
        );

        $options_page->addField(
            [
                'name'  => 'textarea',
                'title' => 'Textarea',
                'type'  => 'textarea',
                'rows'  => 8,
            ]
        );

        $options_page->addField(
            [
                'name'  => 'number',
                'title' => 'Number',
                'type'  => 'number',
                'description' => 'Description about this field.'
            ]
        );

        $options_page->addField(
            [
                'name'  => 'select',
                'title' => 'Select',
                'type'  => 'select',
                'choices' => [
                    'option_1' => 'Option 1',
                    'option_2' => 'Option 2',
                    'option_3' => 'Option 3',
                ],
            ]
        );

        $this->is_initialized = true;
    }

    /**
     * Load textdomain
     *
     * @return void
     */
    public function loadTextdomain()
    {
        load_plugin_textdomain('my-plugin', false, dirname(plugin_basename(MY_PLUGIN_FILE)) . '/languages');
    }
}

