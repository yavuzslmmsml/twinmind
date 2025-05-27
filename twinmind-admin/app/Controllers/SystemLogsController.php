<?php

namespace App\Controllers;

use Core\View;

class SystemLogsController {

    public function index() {

        $test = "sifre";
        View::render('systemLogs/index', [
            'Title' => 'Profile',
            'ProfileDetails' => $test
        ]);
    }



}
