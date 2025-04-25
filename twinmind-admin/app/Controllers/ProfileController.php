<?php

namespace App\Controllers;

use Core\View;

class ProfileController {

    public function index() {

        $test = "sifre";
        View::render('profile', [
            'Title' => 'Profile',
            'ProfileDetails' => $test
        ]);
    }
}
