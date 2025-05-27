<?php

namespace App\Controllers;

use Core\View;

class StatisticsController {

    public function index() {

        $test = "sifre";
        View::render('statistics/index', [
            'Title' => 'Profile',
            'ProfileDetails' => $test
        ]);
    }

     public function mostPopularCourses() {

        $test = "sifre";
        View::render('statistics/mostPopularCourses', [
            'Title' => 'Profile',
            'ProfileDetails' => $test
        ]);
    }

     public function topEarning() {

        $test = "sifre";
        View::render('statistics/topEarning', [
            'Title' => 'Profile',
            'ProfileDetails' => $test
        ]);
    }


}