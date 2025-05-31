<?php

namespace Core;

class Middleware {
    private static array $routeMiddlewares = [];

    public static function addToRoute(string $route, array $middlewares) {
        self::$routeMiddlewares[trim($route, '/')] = $middlewares;
    }

    public static function run(string $uri) {
        $cleanUri = trim($uri, '/');

        foreach (self::$routeMiddlewares as $route => $middlewares) {
            $pattern = preg_replace('#\{[^\}]+\}#', '([^/]+)', $route);
            $regexPattern = "#^$pattern$#";

            if (preg_match($regexPattern, $cleanUri) || $route === $cleanUri) {
                foreach ($middlewares as $middlewareClass) {
                    $fullMiddlewareClass = "App\\Middleware\\$middlewareClass";

                    if (!class_exists($fullMiddlewareClass)) {
                        throw new \Exception("Middleware '$fullMiddlewareClass' not found");
                    }

                    $middleware = new $fullMiddlewareClass();

                    if (!method_exists($middleware, 'handle')) {
                        throw new \Exception("Middleware '$fullMiddlewareClass' must have handle method");
                    }

                    $middleware->handle();
                }
                break;
            }
        }
    }

    public static function getRouteMiddlewares() {
        return self::$routeMiddlewares;
    }
}
