<?php

namespace flowcode\enlace\controller;

use flowcode\enlace\http\HttpRequest;
use flowcode\enlace\view\PlainView;

/**
 * Description of DefaultController
 *
 * @author juanma
 */
class DefaultController extends BaseController {

    function __construct() {
        $this->setIsSecure(false);
    }

    public function defaultMethod(HttpRequest $httpRequest) {
        $viewData["data"] = "Default controller, default method. We strongly recommend to setup your own default controller.";
        return new PlainView($viewData);
    }

}

?>
