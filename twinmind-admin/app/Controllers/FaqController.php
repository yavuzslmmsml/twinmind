<?php

namespace App\Controllers;

use Core\View;

class FaqController {

    public function index() {

        $faqs = [
            ['id' => 1, 'title' => 'İlk Post'],
            ['id' => 2, 'title' => 'İkinci Post'],
        ];

        View::render('faqs/index', [
            'title' => 'F.A.Q',
            'message' => 'Hoş geldiniz! 121414',
            'faqs' => $faqs
        ]);
    }

    public function show($id) {

        View::render('faqs/show', [
            'faq' => $id
        ]);
    }
}
