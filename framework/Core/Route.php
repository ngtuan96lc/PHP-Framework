<?php

declare(strict_types=1);

namespace Eric\Core;

class Route
{
    const CONTROLLER_PATH = "App\\controller\\";

    /**
     * @return void
     */
    public static function execute()
    {
        // Example url
        // http://localhost:8080/
        // http://localhost:8080/product/view/5
        // http://localhost:8080/admin/product/view/5
        $pathInfo = explode('/', $_SERVER['PATH_INFO'] ?? '/');

        /* Determine exactly area */
        $area = "frontend";
        if (!empty($pathInfo[1]) && $pathInfo[1] == "admin") {
            $area = "admin";
            unset($pathInfo[1]);
            $pathInfo = array_values($pathInfo);
        }

        $controllerPart = isset($pathInfo[1]) ? ucfirst($pathInfo[1]) : '';
        $methodPart = isset($pathInfo[2]) ? ucfirst($pathInfo[2]) : '';

        $numParts = count($pathInfo);
        $args = [];
        for ($i = 3; $i < $numParts; $i++) {
            $args[] = $pathInfo[$i];
        }

        /* Set Home controller is default controller */
        $controller = !empty($controllerPart) ? $controllerPart : 'Home';
        $method = !empty($methodPart) ? $methodPart : 'Execute';

        $controller = self::CONTROLLER_PATH . $area . '\\' . $controller;
        (new $controller)->{$method}($args);
    }
}