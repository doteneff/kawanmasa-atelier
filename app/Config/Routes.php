<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Home::index');
    
    $routes->get('/schedules', 'Schedule::index');
    $routes->get('api/schedules/calendar-data', 'Schedule::getCalendarDateList');
    $routes->get('api/schedules/time-slots', 'Schedule::getTimeSlot');
    $routes->post('api/schedules/book', 'Schedule::bookTimeSlot');

    $routes->get('/appointments', 'Appointment::index');
    $routes->get('api/appointments/list', 'Appointment::getAppointmentList');

    $routes->get('/review/view/(:num)', 'Appointment::viewReview/$1');

    $routes->get('/review/write/(:num)', 'Appointment::writeReview/$1');
    $routes->post('/review/(:num)/submit', 'Appointment::submitReview/$1');
});

$routes->get('/logout', 'Auth::logout');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::loginPost');

