<?php

namespace App\Controllers;

use Core\View;

class CategoryController {

    public function index() {

        $test = "sifre";
        View::render('categories/index', [
            'Title' => 'Profile',
            'ProfileDetails' => $test
        ]);
    }
}
