<?php

namespace App\Controllers;

use Core\View;

class InstructorApplicationsController {

    public function index() {

        $test = "sifre";
        View::render('instructorApplications/index', [
            'Title' => 'All Courses',
            'ProfileDetails' => $test
        ]);
    }

}
