<?php

namespace App\Middleware;

class RoleCheck {
    private array $rolePermissions = [
        '2' => ['users', 'categoryAndTagManagement', 'faqs', 'messages', 'courseManagement'],
        '1' => ['users', 'categoryAndTagManagement', 'faqs', 'messages', 'courseManagement'],
        '3' => ['courseManagement']
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
