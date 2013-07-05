<?php

namespace flowcode\wing\config;

use flowcode\wing\mvc\WingSetup;

/**
 * Description of Setup
 *
 * @author juanma
 */
class Setup extends WingSetup {

    function __construct() {
        parent::__construct();

        /* controllers */
        $this->scanneableControllers["demo"] = "\\flowcode\\demo\\controller\\";
        $this->scanneableControllers["wing"] = "\\flowcode\\wing\\controller\\";

        /* dirs */
        $this->dirs['public'] = "/public";
        $this->dirs['log'] = "/log";

        /* default controller */
        $this->defaultController = "\\flowcode\\wing\\controller\\DefaultController";
        $this->defaultMethod = "hello";
        $this->errorMethod = "error";

        /* login manager */
        $this->loginController = "\\flowcode\\wing\\controller\\DefaultController";
        $this->loginMethod = "login";
        $this->restrictedMethod = "restricted";
    }

}

?>
