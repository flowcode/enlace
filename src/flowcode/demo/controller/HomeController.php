<?php

namespace flowcode\demo\controller;

use flowcode\wing\mvc\Controller;
use flowcode\wing\mvc\HttpRequest;
use flowcode\wing\mvc\View;

/**
 * Description of HomeController
 *
 * @author juanma
 */
class HomeController extends Controller {

    public function __construct() {
        $this->setIsSecure(FALSE);
    }

    public function index(HttpRequest $httpRequest) {
        $viewData['data'] = "index";
        return View::getControllerView($this, "demo/view/home/index", $viewData);
    }

}

?>
