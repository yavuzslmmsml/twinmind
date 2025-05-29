<?php

namespace App\Middleware;

class RoleCheck {
    private array $rolePermissions = [
        'admin' => ['users', 'categoryAndTagManagement', 'faqs', 'messages', 'courseManagement'],
        'superuser' => ['users', 'categoryAndTagManagement', 'faqs', 'messages', 'courseManagement'],
        'instructor' => ['courseManagement']
    ];

    public function handle() {

        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        if (!isset($_SESSION['user'])) {
            return;
        }

        $role = $_SESSION['user']['role'] ?? null;

        if (!$role || !isset($this->rolePermissions[$role])) {
            http_response_code(403);
            echo "Erişim reddedildi.";
            exit();
        }

        if (!in_array($uri, $this->rolePermissions[$role])) {
            http_response_code(403);
            echo "Bu sayfaya erişim yetkiniz yok.";
            exit();
        }
    }
}
