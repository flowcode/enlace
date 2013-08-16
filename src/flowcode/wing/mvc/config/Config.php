<?php

namespace flowcode\wing\mvc\config;

/**
 * Description of Config
 *
 * @author juanma
 */
class Config {

    protected static $config = array();

    private function __construct() {
        
    }

    public static function set($key, $val) {
        self::$config[$key] = $val;
    }

    public static function get($key) {
        if (isset(self::$config[$key])) {
            return self::$config[$key];
        } else {
            return NULL;
        }
    }

}

