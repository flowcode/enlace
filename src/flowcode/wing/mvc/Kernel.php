<?php

namespace flowcode\wing\mvc;

use flowcode\wing\mvc\controller\IController;
use flowcode\wing\mvc\http\HttpRequest;
use flowcode\wing\mvc\http\HttpRequestBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Kernel {

    private $configurationFiles = array();
    private $scanneableControllers = array();
    private $dirs = array();
    private $defaultController;
    private $defaultMethod;
    private $errorMethod;
    private $loginController;
    private $loginMethod;
    private $restrictedMethod;
    private $mode;
    public static $MODE_PRODUCTION = 0;
    public static $MODE_DEVELOPMENT = 1;
    public static $MODE_TESTING = 2;

    /**
     * Default mode = 'production'.
     * @param int $mode
     */
    public function __construct($mode = null) {

        if (!is_null($mode)) {
            $this->mode = $mode;
        } else {
            $this->mode = self::$MODE_PRODUCTION;
        }
        $this->defaultController = "\\flowcode\\wing\\mvc\\controller\\DefaultController";
        $this->defaultMethod = "defaultMethod";
        register_shutdown_function(array($this, 'shutdown'));
    }

    protected function setup() {
        
    }

    private function loadConfig() {
        foreach ($this->configurationFiles as $fileToLoad) {
            require_once $fileToLoad;
        }
    }

    /**
     * Handle the requested url dispatching to routed controllers.
     * @param type $requestedUrl
     */
    public function handleRequest($requestedUrl) {
        $this->setup();
        $this->loadConfig();

        $controllersToScan = $this->getScanneableControllers();
        $request = HttpRequestBuilder::buildFromRequestUrl($requestedUrl);

        // scan controller
        $enabledController = FALSE;
        //$moduleName = null;
        foreach ($controllersToScan as $appName => $controllerNamespace) {
            $class = $controllerNamespace . $request->getControllerClass();
            if ($this->validClass($class)) {
                $enabledController = TRUE;
                //$moduleName = $module;
                break;
            }
        }

        if ($enabledController) {
            $controller = new $class();
            //$controller->setModule($moduleName);
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
                //$controller->setModule($moduleName);
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

    private function dispatch(IController $controller, $method, HttpRequest $request) {
        $view = $controller->$method($request);
        $view->render();
    }

    /**
     * Function for show errors based on kernel mode.
     */
    public function shutdown() {
        if (($error = error_get_last())) {
            ob_clean();
            /* log error */
            $msg = $error["message"] . " in file: " . $error["file"] . " on line: " . $error["line"];
            $log = new Logger('kernel');
            $file = $this->getLogDir() . "/log-" . date("Ymd") . ".txt";
            $log->pushHandler(new StreamHandler($file, Logger::ERROR));
            switch ($this->mode) {
                case 'prod':
                    $log->addError($msg);
                    $request = new HttpRequest();
                    $class = $this->getDefaultController();
                    $method = $this->getErrorMethod();
                    $controller = new $class();
                    $this->dispatch($controller, $method, $request);
                    break;
                default:
                    die($msg);
                    break;
            }
        }
    }

    /**
     * Add configuration file to be load.
     * File path must be from root.
     * @param type $filePath
     */
    public function addConfigurationFile($filePath) {
        $this->configurationFiles[] = $filePath;
    }

    /**
     * Add a namespace to lookup.
     * @param type $id
     * @param type $namespace
     */
    public function addScanneableController($appName, $namespace) {
        $this->scanneableControllers[$appName] = $namespace;
    }

    /**
     * Add a dir with its name as a key.
     * @param string $dirName
     * @param string $path
     */
    public function addDir($dirName, $path) {
        $this->dirs[$dirName] = $path;
    }

    /**
     * Get the configured path for dirName.
     * Return null if is not configured.
     * @param type $dirName
     * @return type string
     */
    public function getDirPath($dirName) {
        $dirPath = null;
        if (isset($this->dirs[$dirName])) {
            $dirPath = $this->dirs[$dirName];
        }
        return $dirPath;
    }

    private function validClass($classname) {
        $params = explode('\\', $classname);
        $filename = $this->getDirPath("src");

        $count = (count($params) - 1);
        for ($i = 1; $i <= $count; $i++) {
            $filename .= '/' . $params[$i];
        }
        $filename .= '.php';
        return file_exists($filename);
    }

    public function getScanneableControllers() {
        return $this->scanneableControllers;
    }

    public function setScanneableControllers($scanneableControllers) {
        $this->scanneableControllers = $scanneableControllers;
    }

    public function getDefaultController() {
        return $this->defaultController;
    }

    public function getDefaultMethod() {
        return $this->defaultMethod;
    }

    public function getDirs() {
        return $this->dirs;
    }

    public function getLogDir() {
        return $this->dirs["log"];
    }

    public function setDirs($dirs) {
        $this->dirs = $dirs;
    }

    public function getLoginController() {
        return $this->loginController;
    }

    public function setLoginController($loginController) {
        $this->loginController = $loginController;
    }

    public function getLoginMethod() {
        return $this->loginMethod;
    }

    public function setLoginMethod($loginMethod) {
        $this->loginMethod = $loginMethod;
    }

    public function getRestrictedMethod() {
        return $this->restrictedMethod;
    }

    public function setRestrictedMethod($restrictedMethod) {
        $this->restrictedMethod = $restrictedMethod;
    }

    public function getErrorMethod() {
        return $this->errorMethod;
    }

    public function setErrorMethod($errorMethod) {
        $this->errorMethod = $errorMethod;
    }

    public function getConfigurationFiles() {
        return $this->configurationFiles;
    }

    public function setConfigurationFiles($configurationFiles) {
        $this->configurationFiles = $configurationFiles;
    }

    public function setDefaultController($defaultController) {
        $this->defaultController = $defaultController;
    }

    public function setDefaultMethod($defaultMethod) {
        $this->defaultMethod = $defaultMethod;
    }

    public function setMode($mode) {
        $this->mode = $mode;
    }

    public function getMode() {
        return $this->mode;
    }

}

?>
