<?php

use Core\Router;

Router::add('home/', 'HomeController@index');
Router::add('/', 'HomeController@index');
Router::get('faqs/', 'FaqController@index');
Router::get('faqs/show/{id}', 'FaqController@show');
Router::add('users/', 'UsersController@index');
Router::post('users/add', 'UsersController@addUserAction');
Router::get('users/delete/{id}', 'UsersController@deleteUserAction');
Router::add('users/addUser', 'UsersController@addUser');
Router::add('users/manageRole', 'UsersController@ManageRole');
Router::add('users/deleteUser', 'UsersController@deleteUser');
Router::add('categoryManagement/', 'CategoryController@index');
Router::add('categoryManagement/addCategory', 'CategoryController@addCategory');
Router::add('courseManagement/', 'CourseController@index');
Router::add('courseManagement/addNewCourse', 'CourseController@addNewCourse');
Router::add('courseManagement/manageCourseCategory', 'CourseController@manageCourseCategory');
Router::add('courseManagement/pendingCourseApprovals', 'CourseController@pendingCourseApprovals');
Router::add('instructorApplications/', 'InstructorApplicationsController@index');
Router::add('categoryAndTagManagement/', 'categoryAndTagManagementController@index');
Router::add('categoryAndTagManagement/addDeleteUpdateCategory', 'categoryAndTagManagementController@addDeleteUpdateCategory');

// Yeni kategori yönetimi rotaları
Router::add('category-management/', 'categoryAndTagManagementController@index');
Router::get('category-management/add', 'categoryAndTagManagementController@addCategory');
Router::post('category-management/save', 'categoryAndTagManagementController@saveCategory');
Router::get('category-management/edit/{id}', 'categoryAndTagManagementController@editCategory');
Router::post('category-management/update', 'categoryAndTagManagementController@updateCategory');
Router::get('category-management/delete/{id}', 'categoryAndTagManagementController@deleteCategory');
Router::get('category-management/subcategories', 'categoryAndTagManagementController@getSubCategoriesJson');

Router::add('siteSettings/', 'SiteSettingsController@index');
Router::add('messages/', 'MessagesController@index');
Router::add('messages/reply', 'MessagesController@reply');
Router::add('messages/systemMessages', 'MessagesController@systemMessages');
Router::post('messages/systemMessages', 'MessagesController@AddSystemMessage');
Router::get('messages/systemMessages/delete/{id}', 'MessagesController@systemMessagesDeleteAction');
Router::add('statistics/', 'statisticsController@index');
Router::add('statistics/mostPopularCourses', 'statisticsController@mostPopularCourses');
Router::add('statistics/topEarning', 'statisticsController@topEarning');
Router::get('auth/signin', 'AuthController@signin');
Router::post('auth/signin', 'AuthController@signinAction');
Router::get('auth/signup', 'AuthController@signup');
Router::post('auth/signup', 'AuthController@signupAction');
Router::post('auth/signout', 'AuthController@signout');
