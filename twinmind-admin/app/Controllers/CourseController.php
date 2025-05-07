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
    public function addNewCourse() {

        $test = "sifre";
        View::render('courseManagement/addNewCourse', [
            'Title' => 'All Courses',
            'ProfileDetails' => $test
        ]);
    }
    public function manageCourseCategory() {

        $test = "sifre";
        View::render('courseManagement/manageCourseCategory', [
            'Title' => 'All Courses',
            'ProfileDetails' => $test
        ]);
    }
    public function pendingCourseApprovals() {

        $test = "sifre";
        View::render('courseManagement/pendingCourseApprovals', [
            'Title' => 'All Courses',
            'ProfileDetails' => $test
        ]);
    }
}
