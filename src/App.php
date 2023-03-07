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
            'Checkboxes',
        ];

        foreach ($field_types as $field_type) {
            $class = "\My\Plugin\Fields\\$field_type";
            new $class();
        }

        $options_page = new AdminPages\OptionsPage();


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

