<?php

namespace Core;

class Middleware {
    private static array $middlewares = [];
    private static array $publicRoutes = ['auth/signin', 'auth/signup'];

    // ✅ Rol bazlı erişim izinleri
    // private static array $rolePermissions = [
    //     'superuser' => ['faqs', 'users', 'categoryAndTagManagement', 'courseManagement'],
    //     'admin' => ['faqs', 'users', 'categoryAndTagManagement'],
    //     'instructor' => ['courseManagement']
    // ];

    public static function add($middleware) {
        self::$middlewares[] = $middleware;
    }

    public static function run() {
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        // 🔐 1. Giriş yapılmamışsa ve public değilse -> yönlendir
        // if (!in_array($uri, self::$publicRoutes) && !isset($_SESSION['user'])) {
        //     header('Location: /auth/signin');
        //     exit();
        // }

        // 🔐 2. Giriş yapılmışsa ama public route'a gitmek istiyorsa -> yönlendir
        // if (isset($_SESSION['user']) && in_array($uri, self::$publicRoutes)) {
        //     header('Location: /');
        //     exit();
        // }

        // 🔐 3. Rol kontrolü
        // if (isset($_SESSION['user'])) {
        //     $role = $_SESSION['user']['role'] ?? null;

        //     // Rol tanımlı değilse veya geçerli değilse
        //     if (!$role || !isset(self::$rolePermissions[$role])) {
        //         http_response_code(403);
        //         echo "Erişim reddedildi (rol tanımlı değil).";
        //         exit();
        //     }

        //     // Rolün yetkili sayfa listesinde değilse
        //     if (!in_array($uri, self::$rolePermissions[$role])) {
        //         http_response_code(403);
        //         echo "Bu sayfaya erişim yetkiniz yok.";
        //         exit();
        //     }
        // }

        // 🔄 4. Diğer middleware'leri çalıştır
        foreach (self::$middlewares as $middleware) {
            $instance = new $middleware();
            $instance->handle();
        }
    }
}
