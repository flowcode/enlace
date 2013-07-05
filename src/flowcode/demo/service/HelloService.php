<?php

namespace flowcode\demo\service;

use flowcode\wing\mvc\Config;

/**
 * Description of HelloService
 *
 * @author juanma
 */
class HelloService {

    public function getHelloMessage() {
        $msg = Config::getByModule("demo", "message", "hello");
        return "setup message: $msg";
    }

}

?>
