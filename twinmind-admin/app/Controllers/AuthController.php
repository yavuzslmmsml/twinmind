<?php

namespace App\Controllers;

include __DIR__ . "/../config.php";

use Core\View;

class AuthController {

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



        // Prepare the data for insertion
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $surname = mysqli_real_escape_string($conn, $_POST['surname']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        // Check if email already exists

        $query = "SELECT user_id FROM users WHERE email = '$email'";

        $checkEmail = mysqli_query($conn, $query);
        if (mysqli_num_rows($checkEmail) > 0) {
            $Errors["email"][] = 'You can not use this mail.';
        }

        if (!empty($Errors)) {
            exit(json_encode(['status' => false, 'errors' => $Errors]));
        }

        // Insert new user
        $sql = "INSERT INTO users (name, surname, email, password, role, status, profile_picture, bio, created_at) 
                VALUES ('$name', '$surname', '$email', '$password', 'member', 'passive', NULL, NULL, NOW())";

        if (mysqli_query($conn, $sql)) {
            exit(json_encode(['status' => true, 'message' => 'Registration successful!', 'redirect' => 'auth/signin']));
        } else {
            exit(json_encode(['status' => false, 'errors' => ['general' => ['Registration failed. Please try again.']]]));
        }
    }

    public function signin() {

        // $faqs = [
        //     ['id' => 1, 'title' => 'İlk Post'],
        //     ['id' => 2, 'title' => 'İkinci Post'],
        // ];

        View::render('auth/signin', [
            'title' => 'Sign In'
        ], 'auth_layout');
    }

    function signinAction() {
        global $conn;
        $Errors = [];

        if (!isset($_POST['email']) || empty($_POST['email'])) {
            $Errors['email'][] = 'Email field is required';
        }

        if (!isset($_POST['password']) || empty($_POST['password'])) {
            $Errors['password'][] = 'Password cannot be empty.';
        }

        if (!empty($Errors)) {
            exit(json_encode(['status' => false, 'errors' => $Errors]));
        }
        // Prepare the data for insertion
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        // Check if email already exists

        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            exit(json_encode(['status' => false, 'message' => ['general' => ['Login failed. Please try again.']]]));
        }

        // 4. Kullanıcı bulundu mu?
        if (mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);

            // 5. Şifre yanlış mu?
            if (!password_verify($password, $user['password'])) {
                exit(json_encode(['status' => false, 'errors' => ['password' => ['Incorrect Password']]]));
            }

            if ($user["status"] == 'passive') {
                exit(json_encode(['status' => false, 'message' => 'This user is not active. Please contact support.']));
            }

            // Session'a kullanıcı bilgilerini kaydet
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['logged_in'] = true;
        } else {
            exit(json_encode(['status' => false, 'errors' => ['email' => ['No user found with this email.']]]));
        }

        exit(json_encode(['status' => true, 'message' => 'Login successful!', 'redirect' => 'home']));
    }

    // Oturumu sonlandırmak için yeni bir metod ekleyelim
    public function signout() {
        // Session'ı temizle
        session_unset();
        session_destroy();

        // Kullanıcıyı giriş sayfasına yönlendir
        header('Location: /auth/signin');
        exit();
    }
}