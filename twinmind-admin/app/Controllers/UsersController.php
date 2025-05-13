<?php

namespace App\Controllers;

use Core\View;

class UsersController {

    public function index() {
        global $conn;

        $query = "SELECT `user_id`, `name`, `surname`, `email`, `role`, `status`, `created_at` FROM users";

        $result = mysqli_query($conn, $query);
        View::render('users/index', [
            'Title' => 'Users',
            'Result' => $result
        ]);
    }

    function addUserAction() {
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
        }

        if (!isset($_POST['role']) || empty($_POST['role'])) {
            $Errors['role'][] = 'Please Choose a Role';
        }

        // Prepare the data for insertion
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $surname = mysqli_real_escape_string($conn, $_POST['surname']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role = mysqli_real_escape_string($conn, $_POST['role']);
        // Check if email already exists

        $query = "SELECT user_id FROM users WHERE email = '$email'";

        $checkEmail = mysqli_query($conn, $query);
        if (mysqli_num_rows($checkEmail) > 0) {
            $Errors["email"][] = 'You can not use this mail.';
        }

        // if ($role != 'superuser' || $role != 'admin' || $role != 'instructer' || $role != 'member') {
        //     $Errors["role"][] = $role;
        // }

        if (!empty($Errors)) {
            exit(json_encode(['status' => false, 'errors' => $Errors]));
        }

        // Insert new user
        $sql = "INSERT INTO users (name, surname, email, password, role, status, profile_picture, bio, created_at) 
                VALUES ('$name', '$surname', '$email', '$password', '$role', 'passive', NULL, NULL, NOW())";

        if (mysqli_query($conn, $sql)) {
            exit(json_encode(['status' => true, 'message' => 'User successfully added!', 'redirect' => 'users']));
        } else {
            exit(json_encode(['status' => false, 'errors' => ['general' => ['Registration failed. Please try again.']]]));
        }
    }
    public function addUser() {

        $test = "sifre";
        View::render('users/addUser', [
            'Title' => 'Add user',
            'ProfileDetails' => $test
        ]);
    }
    public function manageRole() {

        $test = "sifre";
        View::render('users/manageRole', [
            'Title' => 'Manage Role',
            'ProfileDetails' => $test
        ]);
    }

    public function deleteUser() {

        $test = "sifre";
        View::render('users/deleteUser', [
            'Title' => 'Manage Role',
            'ProfileDetails' => $test
        ]);
    }
}
