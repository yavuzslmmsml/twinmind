<?php

namespace Core;

class Middleware {
    private static array $middlewares = [];
    private static array $publicRoutes = ['auth/signin', 'auth/signup'];

    public static function add($middleware) {
        self::$middlewares[] = $middleware;
    }

    public static function run() {
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        // Eğer public route değilse ve kullanıcı giriş yapmamışsa
        if (!in_array($uri, self::$publicRoutes) && !isset($_SESSION['user'])) {
            header('Location: /auth/signin');
            exit();
        }

        // Eğer kullanıcı giriş yapmışsa ve public route'a erişmeye çalışıyorsa
        if (isset($_SESSION['user']) && in_array($uri, self::$publicRoutes)) {
            header('Location: /');
            exit();
        }

        foreach (self::$middlewares as $middleware) {
            $instance = new $middleware();
            $instance->handle();
        }
    }
}
