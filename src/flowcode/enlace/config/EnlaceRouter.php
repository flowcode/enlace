<?php

namespace flowcode\enlace\config;

/**
 * Description of EnlaceRouter.
 *
 * @author juanma
 */
class EnlaceRouter {

    protected static $routes = array();

    private function __construct() {
        
    }

    public static function set($key, $val) {
        self::$routes[$key] = $val;
    }

    public static function get($key, $param) {
        if (isset(self::$routes[$key][$param])) {
            return self::$routes[$key][$param];
        } else {
            return NULL;
        }
    }

}

