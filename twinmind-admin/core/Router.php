<?php

namespace Core;

class Router {
    private static array $routes = [];

    public static function add(string $uri, string $controllerMethod) {
        self::$routes['ANY'][trim($uri, '/')] = $controllerMethod;
    }

    public static function get(string $uri, string $controllerMethod) {
        self::$routes['GET'][trim($uri, '/')] = $controllerMethod;
    }

    public static function post(string $uri, string $controllerMethod) {
        self::$routes['POST'][trim($uri, '/')] = $controllerMethod;
    }

    public static function put(string $uri, string $controllerMethod) {
        self::$routes['PUT'][trim($uri, '/')] = $controllerMethod;
    }

    public static function delete(string $uri, string $controllerMethod) {
        self::$routes['DELETE'][trim($uri, '/')] = $controllerMethod;
    }

    public static function dispatch() {
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $method = $_SERVER['REQUEST_METHOD'];

        if ($uri == '') {
            $uri = '/';
        }

        if ($uri == '/' && isset(self::$routes['ANY'][''])) {
            return self::runAction(self::$routes['ANY']['']);
        }

        // Önce ilgili HTTP metot rotalarını kontrol et
        if (isset(self::$routes[$method])) {
            foreach (self::$routes[$method] as $route => $action) {
                $pattern = preg_replace('#\{[^\}]+\}#', '([^/]+)', $route);
                $regexPattern = "#^$pattern$#";

                if (preg_match($regexPattern, $uri, $matches)) {
                    array_shift($matches); // İlk eleman full match
                    return self::runAction($action, $matches);
                }
            }
        }

        if (isset(self::$routes['ANY'])) {
            foreach (self::$routes['ANY'] as $route => $action) {
                $pattern = preg_replace('#\{[^\}]+\}#', '([^/]+)', $route);
                $regexPattern = "#^$pattern$#";

                if (preg_match($regexPattern, $uri, $matches)) {
                    array_shift($matches); // İlk eleman full match
                    return self::runAction($action, $matches);
                }
            }
        }

        http_response_code(404);
        echo "404 - Sayfa Bulunamadı (" . htmlspecialchars($uri) . " bulunamadı)";
    }

    private static function runAction(string $action, array $params = []) {
        [$controller, $method] = explode('@', $action);

        $controllerClass = "App\\Controllers\\$controller";

        if (!class_exists($controllerClass)) {
            throw new \Exception("Controller '$controllerClass' not found");
        }

        $controllerInstance = new $controllerClass();

        if (!method_exists($controllerInstance, $method)) {
            throw new \Exception("Method '$method' not found in $controllerClass");
        }

        call_user_func_array([$controllerInstance, $method], $params);
    }
}
