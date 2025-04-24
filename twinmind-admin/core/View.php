<?php

namespace Core;

class View {
    public static function render($view, $data = [], $layout = 'layout') {

        extract($data);
        ob_start();
        require __DIR__ . "/../views/pages/$view.php";
        $content = ob_get_clean();

        require __DIR__ . "/../views/layouts/$layout.php";
    }
}
