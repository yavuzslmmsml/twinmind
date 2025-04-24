<?php

namespace App\Controllers;

use Core\View;

class AuthController {

    public function login() {

        // $faqs = [
        //     ['id' => 1, 'title' => 'İlk Post'],
        //     ['id' => 2, 'title' => 'İkinci Post'],
        // ];

        View::render('auth/login', [
            'title' => 'Login'
        ], 'auth_layout');
    }

    public function register() {

        View::render('auth/register', [
            'title' => 'Register'
        ], 'auth_layout');
    }
}
