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

        $params = array();

        $arrayParam = explode('?', $requestedUrl);
        if (count($arrayParam) > 1) {
            $array = explode('/', $arrayParam[0]);
        } else {
            $array = explode('/', $requestedUrl);
        }

        /* controller */
        $homepageController = Enlace::getRoute(strtolower("homepage"), "controller");
        $controllerName = (is_null($homepageController) ? "home" : $homepageController);
        if (!empty($array[1])) {
            $controllerName = $array[1];
            // primero intento buscar una ruta definida
            $routedController = Enlace::getRoute(strtolower($array[1]), "controller");
            if ($routedController != NULL) {
                $controllerName = $routedController;
            }
        }
        $instance->setControllerName($controllerName);


        /* action */
        $actionName = "index";
        if (!empty($array[2])) {
            $actionName = $array[2];
            // primero intento buscar una ruta definida
            $actions = Enlace::getRoute(strtolower($controllerName), "actions");
            if ($actions != NULL && isset($actions[$actionName])) {
                $actionName = $actions[$actionName];
            } elseif (isset($actions["*"])) {
                $actionName = $actions["*"];
            }
        } else {
            if (!empty($array[1])) {
                $actionsRoute = $array[1];
            } else {
                $actionsRoute = "homepage";
            }
            $actions = Enlace::getRoute(strtolower($actionsRoute), "actions");
            if ($actions != NULL) {
                $actionName = (isset($actions["default"])) ? $actions["default"] : "index";
            }
        }
        $instance->setAction($actionName);


        foreach ($array as $key => $value) {
            if ($key > 2) {
                $params[] = $value;
            }
        }

        $instance->setParams($params);

        return $instance;
    }

}

?>
