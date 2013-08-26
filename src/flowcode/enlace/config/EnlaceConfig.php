<?php

namespace flowcode\enlace\config;

/**
 * Description of EnlaceConfig
 *
 * @author juanma
 */
class EnlaceConfig {

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

