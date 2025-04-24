<?php

namespace Core;

class Router {
    private static array $routes = [];

    public static function add(string $uri, string $controllerMethod) {
        self::$routes[trim($uri, '/')] = $controllerMethod;
    }

    public static function get(string $uri, string $controllerMethod) {
        self::$routes[trim($uri, '/')] = $controllerMethod;
    }

    public static function post(string $uri, string $controllerMethod) {
        self::$routes[trim($uri, '/')] = $controllerMethod;
    }

    public static function put(string $uri, string $controllerMethod) {
        self::$routes[trim($uri, '/')] = $controllerMethod;
    }

    public static function delete(string $uri, string $controllerMethod) {
        self::$routes[trim($uri, '/')] = $controllerMethod;
    }

    public static function dispatch() {
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        if ($uri == '') {
            $uri = '/';
        }

        echo "<!-- DEBUG: İstek URI: " . $uri . " -->\n";
        echo "<!-- DEBUG: Kayıtlı rotalar: " . print_r(self::$routes, true) . " -->\n";

        if ($uri == '/' && isset(self::$routes[''])) {
            return self::runAction(self::$routes['']);
        }

        foreach (self::$routes as $route => $action) {
            echo "<!-- DEBUG: Rota kontrolü: " . $route . " -->\n";
            $pattern = preg_replace('#\{[^\}]+\}#', '([^/]+)', $route);
            $regexPattern = "#^$pattern$#";
            echo "<!-- DEBUG: Regex: " . $regexPattern . " -->\n";

            if (preg_match($regexPattern, $uri, $matches)) {
                echo "<!-- DEBUG: Eşleşme bulundu: " . print_r($matches, true) . " -->\n";
                array_shift($matches); // İlk eleman full match
                return self::runAction($action, $matches);
            }
        }

        http_response_code(404);
        echo "404 - Sayfa Bulunamadı (" . htmlspecialchars($uri) . " bulunamadı)";
    }

    private static function runAction(string $action, array $params = []) {
        [$controller, $method] = explode('@', $action);
        $controllerClass = "App\\Controllers\\$controller";

        echo "<!-- DEBUG: Controller çağrılıyor: " . $controllerClass . "@" . $method . " -->\n";

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
