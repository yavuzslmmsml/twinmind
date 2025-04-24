<?php

use Core\Router;

Router::add('/', 'HomeController@index');
Router::get('faqs/', 'FaqController@index');
Router::get('faqs/show/{id}', 'FaqController@show');
Router::add('profile', 'ProfileController@index');
Router::get('auth/login', 'AuthController@login');
Router::get('auth/register', 'AuthController@register');
