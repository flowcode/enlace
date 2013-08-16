<?php

namespace flowcode\common;

use flowcode\wing\mvc\Kernel;

/**
 * Description of AppKernel
 *
 * @author Juan Manuel Agüero <jaguero@flowcode.com.ar>
 */
class App extends Kernel {

    protected function setup() {


        /* config fils location */
        $this->addConfigurationFile(__DIR__ . "/config/config.php");
        $this->addConfigurationFile(__DIR__ . "/config/routing.php");
        $this->addConfigurationFile(__DIR__ . "/config/database.php");

        /* controllers */
        $this->addScanneableController("demo", "\\flowcode\\demo\\controller\\");
        $this->addScanneableController("cms", "\\flowcode\\cms\\controller\\");
        $this->addScanneableController("wing", "\\flowcode\\wing\\controller\\");

        /* dirs */
        $this->addDir('src', __DIR__ . "/../..");
        $this->addDir('log', __DIR__ . "/../../log");
        $this->addDir('public', "/");

        /* default controller */
        $this->setDefaultController("\\flowcode\\cms\\controller\\PageController");
        $this->setDefaultMethod("manage");
        $this->setErrorMethod("error");

        /* login manager */
        $this->setLoginController("\\flowcode\\wing\\controller\\DefaultController");
        $this->setLoginMethod("login");
        $this->setRestrictedMethod("restricted");
        
    }

}

?>
