<?php

namespace App\Controllers;

use Core\View;

class ProfileController {

    public function index() {

        $Details = [
            'Name' => 'Talha',
            'Surname' => 'Bekci',
            'Age' => 23
        ];

        View::render('profile', [
            'Title' => 'Profile',
            'ProfileDetails' => $Details
        ]);
    }
}
