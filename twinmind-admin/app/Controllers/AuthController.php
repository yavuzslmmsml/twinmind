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

        if (isset($_POST["data"])) {
            $name = $_POST["name"];
            $surname = $_POST["surname"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $data = [
                ['name' => $name, 'surname' => $surname, 'email' => $email,  'password' => $password,],

            ];

            View::render('auth/signup', [
                'title' => 'Sign Up',
                'data' => $data
            ], 'auth_layout');
        } else {
            View::render('auth/signup', [
                'title' => 'Sign Up',
                'data' => 'yok'
            ], 'auth_layout');
        }
    }
}
