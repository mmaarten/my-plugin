<?php

namespace My\Plugin;

class App
{
    private static $_instance = null;

    public static function getInstance()
    {
        if (! self::$_instance) {
            self::$_instance = new App();
        }

        return self::$_instance;
    }

    private final function __construct()
    {
    }

    public function init()
    {
    }
}
