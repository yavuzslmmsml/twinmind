<?php

if (!function_exists('dd')) {
    function dd($Vars = '', $Die = true) {
        echo '<pre>';
        print_r($Vars);
        echo '</pre>';

        if ($Die) {
            die;
        }
    }
}
