<?php

namespace flowcode\wing\controller;

use flowcode\wing\mvc\Controller;
use flowcode\wing\mvc\View;

/**
 * Description of DefaultController
 *
 * @author juanma
 */
class DefaultController extends Controller {

    function __construct() {
        $this->setIsSecure(false);
        $this->setName("defaultController");
        $this->setModule("wing");
    }

    public function hello() {
        $viewData["data"] = "wing hello!";
        return View::getPlainView($this, "wing/view/page/data-page", $viewData);
    }

    public function error() {
        $viewData['data'] = "";
        return View::getViewWithSpecificMaster($this, "wing/view/page/error-page", $viewData, "wing/view/master-static");
    }

}

?>
