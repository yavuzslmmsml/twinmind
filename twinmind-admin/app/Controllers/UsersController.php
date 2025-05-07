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
