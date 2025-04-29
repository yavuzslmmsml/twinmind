<?php

namespace App\Controllers;

include __DIR__ . "/../config.php";

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
        global $conn;
        $Errors = [];

        if (!isset($_POST['name']) || empty($_POST['name'])) {
            $Errors['name'][] = 'Name field is required';
        }

        if (!isset($_POST['surname']) || empty($_POST['surname'])) {
            $Errors['surname'][] = 'Surname field is required';
        }

        if (!isset($_POST['email']) || empty($_POST['email'])) {
            $Errors['email'][] = 'Email field is required';
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

        if (!isset($_POST['toc']) || empty($_POST['toc'])) {
            $Errors['toc'][] = '';
        }

        if (!empty($Errors)) {
            exit(json_encode(['status' => false, 'errors' => $Errors]));
        }

        // Prepare the data for insertion
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $surname = mysqli_real_escape_string($conn, $_POST['surname']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Check if email already exists

        $query = "SELECT user_id FROM users WHERE email = '$email'";
        $checkEmail = mysqli_query($conn, $query);
        if (mysqli_num_rows($checkEmail) > 0) {
            exit(json_encode(['status' => false, 'errors' => ['email' => ['This email is already registered.']]]));
        }

        // Insert new user
        $sql = "INSERT INTO users (name, surname, email, password, role, profile_picture, bio, created_at) 
                VALUES ('$name', '$surname', '$email', '$password', 'member', NULL, NULL, NOW())";

        if (mysqli_query($conn, $sql)) {
            exit(json_encode(['status' => true, 'message' => 'Registration successful!', 'redirect' => 'auth/signin']));
        } else {
            exit(json_encode(['status' => false, 'errors' => ['general' => ['Registration failed. Please try again.']]]));
        }
    }
}
