<?php

namespace core\router;

use core\request;
use core\helpers;

function routing(): void
{
    $routes = include ROUTES;
    $url = parse_url(request\get_url());
    $path = $url['path'] ?? '';
    $method = request\get_method();
    $controller = CONTROLLERS . '/errors/404.php';

    foreach ($routes as $route => $properties) {
        $matches = [];

        if (preg_match($route, $path, $matches) && $properties['method'] == $method) {

            if (isset($properties['controller'])) {
                $controller = CONTROLLERS . "/{$properties['controller']}.php";

                if (file_exists($controller)) {

                    if (isset($properties['middleware']) && is_array($properties['middleware'])) {

                        foreach ($properties['middleware'] as $middleware) {

                            if (is_string($middleware)) {
                                $middleware_path = MIDDLEWARE . "/$middleware.php";

                                if (file_exists($middleware_path)) {
                                    $middleware = "core\\middleware\\$middleware\\handle";
                                    call_user_func(callback: $middleware);
                                } else {
                                    helpers\write_to_log("Middleware $middleware_path not found", __FILE__);
                                    $controller = CONTROLLERS . '/errors/500.php';
                                }
                            } else {
                                helpers\write_to_log("Middleware name is not a string for route: $path", __FILE__);
                                $controller = CONTROLLERS . '/errors/500.php';
                            }

                        }

                    }

                    break;
                } else {
                    helpers\write_to_log("Controller $controller not found", __FILE__);
                    $controller = CONTROLLERS . '/errors/500.php';
                }
            }

        }

    }
    require $controller;
}