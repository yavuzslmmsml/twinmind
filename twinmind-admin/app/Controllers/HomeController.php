<?php

namespace App\Controllers;

use Core\View;

class HomeController {
    public function index() {


        View::render('home/index', [
            'title' => 'Home',
            'message' => 'TWINMIND'
        ]);
    }
}
