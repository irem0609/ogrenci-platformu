<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', 'Home::index');


// REGISTER
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::register');


// LOGIN
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::login');


// LOGOUT
$routes->get('/logout', 'Auth::logout');


// STUDENT DASHBOARD
$routes->get(
    '/student/dashboard',
    'Student::dashboard',
    ['filter' => 'auth']
);


// STUDENT LIBRARY
$routes->get(
    '/student/library',
    'Library::index',
    ['filter' => 'auth']
);

$routes->get(
    '/student/library/add',
    'Library::add',
    ['filter' => 'auth']
);

$routes->post(
    '/student/library/add',
    'Library::add',
    ['filter' => 'auth']
);


// STUDENT PLANNER
$routes->get(
    '/student/planner',
    'Student::planner',
    ['filter' => 'auth']
);


// STUDENT CHATBOT
$routes->get(
    '/student/chatbot',
    'Student::chatbot',
    ['filter' => 'auth']
);


// STUDENT PROFILE
$routes->get(
    '/student/profile',
    'Student::profile',
    ['filter' => 'auth']
);