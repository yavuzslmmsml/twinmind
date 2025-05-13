<?php

namespace App\Controllers;

use Core\View;

class MessagesController {

    public function index() {

        $test = "sifre";
        View::render('messages/index', [
            'Title' => 'All Courses',
            'ProfileDetails' => $test
        ]);
    }

    public function reply() {

        $test = "sifre";
        View::render('messages/reply', [
            'Title' => 'All Courses',
            'ProfileDetails' => $test
        ]);
    

}
}