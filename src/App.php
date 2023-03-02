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

