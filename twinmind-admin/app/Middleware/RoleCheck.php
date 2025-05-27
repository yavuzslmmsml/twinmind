<?php

namespace App\Middleware;

use Closure;

class RoleCheck {
    private array $rolePermissions = [
        'admin' => ['users', 'categoryAndTagManagement', 'faqs', 'messages', 'courseManagement'],
        'superuser' => ['users', 'categoryAndTagManagement', 'faqs', 'messages', 'courseManagement'],
        'instructor' => ['courseManagement']
    ];

    public function handle($request, Closure $next) {
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        // Giriş yapılmamışsa kontrol etme
        if (!isset($_SESSION['user'])) {
            return;
        }

        $role = $_SESSION['user']['role'] ?? null;

        // Eğer rol tanımlı değilse ya da rol için izinli sayfa listesi yoksa engelle
        if (!$role || !isset($this->rolePermissions[$role])) {
            http_response_code(403);
            echo "Access Denied.";
            exit();
        }

        // Eğer bu rolün erişim izni olmayan bir sayfaya erişmeye çalışılıyorsa
        if (!in_array($uri, $this->rolePermissions[$role])) {
            http_response_code(403);
            echo "Access Denied";
            exit();
        }

        return $next($request);
    }
}
