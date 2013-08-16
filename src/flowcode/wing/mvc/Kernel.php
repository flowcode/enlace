<?php

namespace flowcode\wing\mvc;

use flowcode\wing\mvc\controller\Controller;
use flowcode\wing\mvc\http\HttpRequest;
use flowcode\wing\mvc\http\HttpRequestBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Kernel {

    protected $configurationFiles;
    protected $scanneableControllers;
    protected $dirs;
    protected $defaultController;
    protected $defaultMethod;
    protected $errorMethod;
    protected $loginController;
    protected $loginMethod;
    protected $restrictedMethod;
    protected $mode;

    public function __construct($mode = 'prod') {
        session_start();
        $this->mode = $mode;

        if ('prod' == $this->mode) {
            register_shutdown_function(array($this, 'shutdown'));
        }
    }

    protected function setup() {
        
    }

    private function loadConfig() {
        foreach ($this->configurationFiles as $fileToLoad) {
            require_once $fileToLoad;
        }
    }

    public function handleRequest($requestedUrl) {
        $this->setup();
        $this->loadConfig();

        $controllersToScan = $this->getScanneableControllers();
        $request = $this->getRequest($requestedUrl);

        // scan controller
        $enabledController = FALSE;
        $moduleName = null;
        foreach ($controllersToScan as $module => $controllerNamespace) {
            $class = $controllerNamespace . $request->getControllerClass();

            if ($this->validClass($class)) {
                $enabledController = TRUE;
                $moduleName = $module;
                break;
            }
        }


        if ($enabledController) {
            $controller = new $class();
            $controller->setModule($moduleName);
            $controller->setName($request->getControllerName());
        } else {

            $class = $this->getDefaultController();
            $request->setAction($this->getDefaultMethod());
            $controller = new $class();
        }

        // seguridad a nivel controller
        if ($controller->isSecure()) {

            if (!isset($_SESSION['user']['username'])) {

                // Si no esta atenticado, lo llevo a la pantalla de autenticacion.
                $request = new HttpRequest("");
                $request->setAction($this->getLoginMethod());
                $class = $this->getLoginController();
                $controller = new $class();
                $controller->setModule($moduleName);
            } else {

                // Si esta atenticado, verifico que tenga un rol valido para el controller.
                if (!$controller->canAccess($_SESSION['user']['role'])) {
                    $request = new HttpRequest("");
                    $request->setAction($this->getRestrictedMethod());
                    $request->setControllerName("usuario");
                    $class = $this->getLoginController();
                    $controller = new $class();
                }
            }
        }
        $method = $request->getAction();
        $this->dispatch($controller, $method, $request);
    }

    private function dispatch(Controller $controller, $method, HttpRequest $request) {
        $view = $controller->$method($request);
        $view->render();
    }

    public function getRequest($requestedUrl) {
        $request = HttpRequestBuilder::buildFromRequestUrl($requestedUrl);
        return $request;
    }

    public function shutdown() {
        if (($error = error_get_last())) {
            ob_clean();
            /* log error */
            $log = new Logger('name');
            $log->pushHandler(new StreamHandler($this->getLogDir(), Logger::WARNING));
            //KLogger::instance($this->getLogDir())->logCrit($error["message"]);
            switch ($this->mode) {
                case 'prod':
                    $log->addError($error["message"]);
                    break;
                default:
                    break;
            }

            $request = new HttpRequest();
            $class = $this->getDefaultController();
            $method = $this->getErrorMethod();
            $controller = new $class();
            $this->dispatch($controller, $method, $request);
        }
    }

    private function validClass($classname) {
        $params = explode('\\', $classname);
        $filename = $this->dirs["src"];

        $count = (count($params) - 1);
        for ($i = 1; $i <= $count; $i++) {
            $filename .= '/' . $params[$i];
        }
        $filename .= '.php';
        return file_exists($filename);
    }

    protected function getScanneableControllers() {
        return $this->scanneableControllers;
    }

    protected function setScanneableControllers($scanneableControllers) {
        $this->scanneableControllers = $scanneableControllers;
    }

    protected function getDefaultController() {
        return $this->defaultController;
    }

    protected function getDefaultMethod() {
        return $this->defaultMethod;
    }

    protected function getDirs() {
        return $this->dirs;
    }

    protected function getLogDir() {
        return $this->dirs["log"];
    }

    protected function setDirs($dirs) {
        $this->dirs = $dirs;
    }

    protected function getLoginController() {
        return $this->loginController;
    }

    protected function setLoginController($loginController) {
        $this->loginController = $loginController;
    }

    protected function getLoginMethod() {
        return $this->loginMethod;
    }

    protected function setLoginMethod($loginMethod) {
        $this->loginMethod = $loginMethod;
    }

    protected function getRestrictedMethod() {
        return $this->restrictedMethod;
    }

    protected function setRestrictedMethod($restrictedMethod) {
        $this->restrictedMethod = $restrictedMethod;
    }

    protected function getErrorMethod() {
        return $this->errorMethod;
    }

    protected function setErrorMethod($errorMethod) {
        $this->errorMethod = $errorMethod;
    }

    public function getConfigurationFiles() {
        return $this->configurationFiles;
    }

    public function setConfigurationFiles($configurationFiles) {
        $this->configurationFiles = $configurationFiles;
    }

    /**
     * Add configuration file to be load.
     * File path must be from root.
     * @param type $filePath
     */
    public function addConfigurationFile($filePath) {
        $this->configurationFiles[] = $filePath;
    }

}

?>
