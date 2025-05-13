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

    
    public function addDeleteUpdateCategory() {

        $test = "sifre";
        View::render('categoryandTagManagement/addDeleteUpdateCategory', [
            'Title' => 'Profile',
            'ProfileDetails' => $test
        ]);
    }
}