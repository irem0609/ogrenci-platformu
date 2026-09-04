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
$routes->post(
    '/student/library/update',
    'Library::updateBook',
     ['filter' => 'auth']
 );




// STUDENT CHATBOT
$routes->get(
    '/student/chatbot',
    'Student::chatbot',
    ['filter' => 'auth']
);
$routes->post(
    '/student/chatbot/send',
    'Student::sendChatMessage', 
    ['filter' => 'auth']
);

// STUDENT PROFILE
$routes->get(
    '/student/profile',
    'Student::profile',
    ['filter' => 'auth']
);
$routes->post(
    '/student/profile/update-email',
    'Student::updateEmail',
    ['filter' => 'auth']
);
$routes->post(
    '/student/profile/update-password',
    'Student::updatePassword',
    ['filter' => 'auth']
);

// STUDENT PLANNER

$routes->get(
    '/student/planner',
    'Planner::index',
    ['filter' => 'auth']
);
$routes->get(
    '/student/planner/add-event',
    'Planner::showAddEvent',
    ['filter' => 'auth']
);

$routes->post(
    '/student/planner/add-event',
    'Planner::addEvent',
    ['filter' => 'auth']
);

$routes->get(
    '/student/planner/toggle-event/(:num)',
    'Planner::toggleEvent/$1',
    ['filter' => 'auth']
);

$routes->get(
    '/student/planner/delete-event/(:num)',
    'Planner::deleteEvent/$1',
    ['filter' => 'auth']
);
$routes->get(
    '/student/planner/add-reminder',
    'Planner::showAddReminder',
    ['filter' => 'auth']
);
$routes->post(
    '/student/planner/add-reminder',
    'Planner::addReminder',
    ['filter' => 'auth']
);

$routes->get(
    '/student/planner/toggle-reminder/(:num)',
    'Planner::toggleReminder/$1',
    ['filter' => 'auth']
);

$routes->get(
    '/student/planner/delete-reminder/(:num)',
    'Planner::deleteReminder/$1',
    ['filter' => 'auth']
);