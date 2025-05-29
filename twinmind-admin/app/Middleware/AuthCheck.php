<?php

namespace App\Middleware;

class AuthCheck {
    public function handle() {
        if (!isset($_SESSION['user'])) {
            header('Location: /auth/signin');
            exit();
        }
    }
}
