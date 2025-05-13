<?php

namespace App\Controllers;

use Core\View;

class categoryAndTagManagementController {

    public function index() {

        $test = "sifre";
        View::render('categoryandTagManagement/index', [
            'Title' => 'Profile',
            'ProfileDetails' => $test
        ]);
    }

}