<?php

namespace App\Controllers;

use Core\View;

class AuthController {

    public function signin() {

        // $faqs = [
        //     ['id' => 1, 'title' => 'İlk Post'],
        //     ['id' => 2, 'title' => 'İkinci Post'],
        // ];

        View::render('auth/signin', [
            'title' => 'Sign In'
        ], 'auth_layout');
    }

    public function signup() {

        View::render('auth/signup', [
            'title' => 'Sign Up'
        ], 'auth_layout');
    }
}
