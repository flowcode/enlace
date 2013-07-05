<?php

namespace flowcode\demo\controller;

use flowcode\demo\domain\Demo;
use flowcode\demo\service\DemoService;
use flowcode\demo\service\HelloService;
use flowcode\wing\mvc\Controller;
use flowcode\wing\mvc\HttpRequest;
use flowcode\wing\mvc\View;

/**
 * Description of HomeController
 *
 * @author juanma
 */
class DemoController extends Controller {

    public function __construct() {
        $this->setIsSecure(FALSE);
    }

    public function message(HttpRequest $httpRequest) {
        $helloSrv = new HelloService();
        $viewData["message"] = $helloSrv->getHelloMessage();
        return View::getControllerView($this, "demo/view/demo/message", $viewData);
    }

    public function index(HttpRequest $httpRequest) {
        $demoSrv = new DemoService();
        $viewData["demos"] = $demoSrv->findAll();
        return View::getControllerView($this, "demo/view/demo/list", $viewData);
    }

    public function create(HttpRequest $httpRequest) {
        $viewData["data"] = "";
        return View::getControllerView($this, "demo/view/demo/create", $viewData);
    }

    public function save(HttpRequest $httpRequest) {
        $demoSrv = new DemoService();
        $demo = new Demo();
        $demo->setName($httpRequest->getParameter("name"));
        $demoSrv->save($demo);
        $this->redirect("/demo");
    }

}

?>
