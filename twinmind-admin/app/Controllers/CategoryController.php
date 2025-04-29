<?php

namespace App\Controllers;

use Core\View;

class CategoryController {

    public function index() {

        $test = "sifre";
        View::render('categoryManagement/index', [
            'Title' => 'Profile',
            'ProfileDetails' => $test
        ]);
    }

    public function addCategory() {

        $test = "sifre";
        View::render('categoryManagement/addCategory', [
            'Title' => 'Add Category',
            'ProfileDetails' => $test
        ]);
    }
}
