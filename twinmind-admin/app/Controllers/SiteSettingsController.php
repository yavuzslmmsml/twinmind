<?php

namespace App\Controllers;

use Core\View;

class SiteSettingsController {

    public function index() {

        $test = "sifre";
        View::render('siteSettings/index', [
            'Title' => 'Profile',
            'ProfileDetails' => $test
        ]);
    }



}





