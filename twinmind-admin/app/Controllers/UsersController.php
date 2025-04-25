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
}
