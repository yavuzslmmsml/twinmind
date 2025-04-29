<?php

namespace App\Controllers;

use Core\View;

class CourseController {

    public function index() {

        $test = "sifre";
        View::render('courseManagement/index', [
            'Title' => 'All Courses',
            'ProfileDetails' => $test
        ]);
    }
}
