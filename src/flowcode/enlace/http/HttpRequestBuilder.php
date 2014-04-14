<?php

namespace flowcode\enlace\http;

use flowcode\enlace\Enlace;

/**
 * Description of HttpRequestBuilder
 *
 * @author juanma
 */
class HttpRequestBuilder {

    /**
     * Build a HttpRequest instance.
     * @param type $requestedUrl
     * @return HttpRequest
     */
    public static function buildFromRequestUrl($requestedUrl) {
        $instance = new HttpRequest();
        $instance->setRequestedUrl($requestedUrl);

        /* strip get parameters */
        $arrayParam = explode('?', $requestedUrl);
        if (count($arrayParam) > 1) {
            $explodedUrl = explode('/', $arrayParam[0]);
        } else {
            $explodedUrl = explode('/', $requestedUrl);
        }

        /* i18n */
        $baseIndex = 0;
        if (isset($explodedUrl[1]) && !is_null(Enlace::get("lang", "available"))) {
            foreach (Enlace::get("lang", "available") as $lang => $desc) {
                if ($explodedUrl[1] == $lang) {
                    $instance->setLang($explodedUrl[1]);
                    $baseIndex = 1;
                    break;
                }
            }
        }

        /* look for registered routes */
        $registeredRoutes = Enlace::getRoutes();
        $route = null;
        $parameters = array();
        foreach ($registeredRoutes as $pattern => $foundRouteVal) {
            /* pattern to regex */
            $filterSlashes = preg_replace("/\//i", '\/', preg_replace("/:[^\/]*/i", '.*', $pattern));
            $regex = "/" . $filterSlashes . "$/";
            echo "\n" . $regex;
            if (preg_match($regex, $requestedUrl)) {
                if (isset($foundRouteVal["method"]) && strtolower($_SERVER['REQUEST_METHOD']) != strtolower($foundRouteVal["method"])) {
                    continue;
                }

                /* fill parameters */
                $params = preg_grep("/:\b/", explode("/", $pattern));
                $explodedPattern = explode("/", $pattern);
                for ($pos = 0; $pos < count($explodedPattern); $pos++) {
                    if (in_array($explodedPattern[$pos], $params)) {
                        $paramId = str_replace(":", "", $explodedPattern[$pos]);
                        $parameters[$paramId] = $explodedUrl[$pos + $baseIndex];
                    }
                }
                /* set values */
                $instance->setParams($parameters);
                $route = $foundRouteVal;
                break;
            }
        }

        if (!is_null($route)) {
            if (isset($route["controller"])) {
                $pos = strpos($route["controller"], ":");
                if ($pos !== false && $pos == 0) {
                    $instance->setControllerName($instance->getParameter(substr($route["controller"], 1)));
                } else {
                    $instance->setControllerName($route["controller"]);
                }
            }
            if (isset($route["action"])) {
                $pos = strpos($route["action"], ":");
                if ($pos !== false && $pos == 0) {
                    $instance->setAction($instance->getParameter(substr($route["action"], 1)));
                } else {
                    $instance->setAction($route["action"]);
                }
            }
        }

        return $instance;
    }

}

?>
