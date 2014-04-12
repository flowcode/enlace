<?php

namespace flowcode\enlace\http;

/**
 * 
 */
class HttpRequest {

    private $lang;
    private $requestedUrl;
    private $controller;
    private $action;
    private $params;
    private $method;

    public function __construct() {
        $this->params = array();
    }

    public function setRequestedUrl($requestedUrl) {
        $this->requestedUrl = $requestedUrl;
    }

    public function getControllerClass() {
        return ucwords($this->controller) . "Controller";
    }

    public function getControllerName() {
        return $this->controller;
    }

    public function setControllerName($controllerName) {
        $this->controller = $controllerName;
    }

    public function getAction() {
        return $this->action;
    }

    public function setAction($actionName) {
        $this->action = $actionName;
    }
    
    public function getMethod() {
        return $this->method;
    }

    public function setMethod($method) {
        $this->method = $method;
    }

    
    /**
     * Retorna los parametros del request.
     * @return type 
     */
    public function getParams() {
        return $this->params;
    }

    public function setParams($params) {
        $this->params = $params;
    }

    /**
     * Retorna el valor del parametro.
     * Si no existe retorna NULL.
     * 
     * @param String $parameter
     * @return String value. 
     */
    public function getParameter($parameter) {
        $value = NULL;
        if ($parameter != NULL) {
            if (isset($this->params[$parameter])) {
                $value = $this->params[$parameter];
            }
        }
        if (is_null($value)) {
            if (isset($_POST[$parameter])) {
                $value = $_POST[$parameter];
            }
        }
        if (is_null($value)) {
            if (isset($_GET[$parameter])) {
                $value = $_GET[$parameter];
            }
        }
        if (is_string($value)) {
            $value = urldecode($value);
        }
        return $value;
    }

    public function getRequestedUrl() {
        return $this->requestedUrl;
    }

    public function getLang() {
        return $this->lang;
    }

    public function setLang($lang) {
        $this->lang = $lang;
    }

}

?>
