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
            'title' => 'Sign Up',
            'data' => 'yok'
        ], 'auth_layout');
    }

    function signupAction() {

        $Errors = [];

        if (!isset($_POST['email']) || empty($_POST['email'])) {
            $Errors['email'][] = 'Email field is required';
        }

        if (!isset($_POST['name']) || empty($_POST['name'])) {
            $Errors['name'][] = 'Name field is required';
        }

        if (!isset($_POST['password']) || empty($_POST['password'])) {
            $Errors['password'][] = 'Password cannot be empty.';
        } else {
            if (strlen($_POST['password']) < 8) {
                $Errors['password'][] = 'Password length must be at least 8 characters.';
            }
            if (!preg_match('/[0-9]/', $_POST['password'])) {
                $Errors['password'][] = 'Password must contain at least one number.';
            }
            if ($_POST['password'] != $_POST['confirm-password']) {
                $Errors['password'][] = 'Passwords does not match.';
            }
        }

        if (!empty($Errors)) {
            exit(json_encode(['status' => false, 'errors' => $Errors]));
        }
    }
}
