<?php

namespace flowcode\enlace;

use flowcode\enlace\controller\IController;
use flowcode\enlace\http\HttpRequest;
use flowcode\enlace\http\HttpRequestBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Enlace {

    protected static $config = array();
    protected static $routes = array();
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
        register_shutdown_function(array($this, 'shutdown'));
    }

    /**
     * Handle the requested url dispatching to routed controllers.
     * @param type $requestedUrl
     */
    public function handleRequest($requestedUrl) {
        $controllersToScan = self::$config["scanneableControllers"];
        $request = HttpRequestBuilder::buildFromRequestUrl($requestedUrl);

        /* check mode */
        if ($this->getMode() != self::$MODE_TESTING) {
            session_start();
            $_SESSION["lang"] = $request->getLang();
        }

        // scan controller
        $enabledController = FALSE;
        foreach ($controllersToScan as $appName => $controllerNamespace) {
            $class = $controllerNamespace . $request->getControllerClass();
            if ($this->validClass($class)) {
                $enabledController = TRUE;
                break;
            }
        }

        if ($enabledController) {
            $controller = new $class();
            $controller->setName($request->getControllerName());
        } else {

            $class = self::get("defaultController");
            $request->setAction(self::get("defaultMethod"));
            $controller = new $class();
        }

        // controller security
        if ($controller->isSecure()) {

            if (!isset($_SESSION['user']['username'])) {

                // not authenticated
                $request = new HttpRequest("");
                $request->setAction(self::get("loginMethod"));
                $class = self::get("loginController");
                $controller = new $class();
            } else {

                // authenticated
                if (!$controller->canAccess($_SESSION['user'])) {
                    $request = new HttpRequest("");
                    $request->setAction(self::get("restrictedMethod"));
                    $request->setControllerName("user");
                    $class = self::get("defaultController");
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
            $file = self::get("dir", "log") . "/log-" . date("Ymd") . ".txt";
            $log->pushHandler(new StreamHandler($file, Logger::ERROR));
            switch ($this->mode) {
                case self::$MODE_PRODUCTION:
                    $log->addError($msg);
                    $request = new HttpRequest();
                    $class = self::get("defaultController");
                    $method = self::get("errorMethod");
                    $controller = new $class();
                    $this->dispatch($controller, $method, $request);
                    break;
                case self::$MODE_DEVELOPMENT:
                    die($msg);
                    break;

                default:
                    echo $msg;
                    break;
            }
        }
    }

    private function validClass($classname) {
        $params = explode('\\', $classname);
        $filename = self::get("dir", "src");

        $count = (count($params) - 1);
        for ($i = 1; $i <= $count; $i++) {
            $filename .= '/' . $params[$i];
        }
        $filename .= '.php';
        return file_exists($filename);
    }

    public static function setRoute($key, $val) {
        self::$routes[$key] = $val;
    }

    public static function getRoute($key, $param) {
        if (isset(self::$routes[$key][$param])) {
            return self::$routes[$key][$param];
        } else {
            return NULL;
        }
    }

    public static function set($key, $val) {
        self::$config[$key] = $val;
    }

    public static function get($key1, $key2 = null, $key3 = null) {
        if (isset(self::$config[$key1])) {
            if (!is_null($key2) && isset(self::$config[$key1][$key2])) {
                if (!is_null($key3) && isset(self::$config[$key1][$key2][$key3])) {
                    return self::$config[$key1][$key2][$key3];
                } else {
                    return self::$config[$key1][$key2];
                }
            } else {
                return self::$config[$key1];
            }
        } else {
            return null;
        }
    }

    public function setMode($mode) {
        $this->mode = $mode;
    }

    public function getMode() {
        return $this->mode;
    }

}

?>
