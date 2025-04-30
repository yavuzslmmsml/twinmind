<?php

namespace App\Controllers;

use Core\View;

class UsersController {

    public function index() {

        $test = "sifre";
        View::render('users/index', [
            'Title' => 'Profile',
            'ProfileDetails' => $test
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
