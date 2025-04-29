<?php

use Core\Router;

Router::add('home/', 'HomeController@index');
Router::add('/', 'HomeController@index');
Router::get('faqs/', 'FaqController@index');
Router::get('faqs/show/{id}', 'FaqController@show');
Router::add('users/', 'UsersController@index');
Router::add('categoryManagement/', 'CategoryController@index');
Router::add('categoryManagement/addCategory', 'CategoryController@addCategory');
Router::add('courseManagement/', 'CourseController@index');
Router::get('auth/signin', 'AuthController@signin');
Router::get('auth/signup', 'AuthController@signup');
Router::post('auth/signup', 'AuthController@signupAction');
