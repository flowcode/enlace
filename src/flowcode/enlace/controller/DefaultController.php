<?php

namespace flowcode\enlace\controller;

use flowcode\enlace\view\PlainView;

/**
 * Description of DefaultController
 *
 * @author juanma
 */
class DefaultController extends BaseController{

    function __construct() {
        $this->setIsSecure(false);
        $this->setName("defaultController");
        $this->setModule("wing");
    }

    public function defaultMethod() {
        $viewData["data"] = "Default controller, default method. We strongly recommend to setup your own default controller.";
        return new PlainView($viewData);
    }

}

?>
