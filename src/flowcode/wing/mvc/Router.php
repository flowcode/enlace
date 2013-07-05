<?php

namespace flowcode\wing\mvc;

/**
 * Description of Router.
 *
 * @author juanma
 */
class Router {

    
    public static function get($section, $param) {
        
        //$framework_base = '/var/www/inter/web/flowcode/';
        $framework_base = dirname ( __FILE__ )."/../../";
        
        // Parse with sections
        $config = parse_ini_file($framework_base."common/config/routing.ini", true);
        if(isset($config[$section][$param])){
            return $config[$section][$param];
        }else{
            return NULL;
        }
        
    }

}

