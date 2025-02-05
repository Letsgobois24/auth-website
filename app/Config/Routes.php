
<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('/', static function ($routes){
    $routes->add('', 'Auth::index');
    $routes->match(['GET', 'POST'],'registration', 'Auth::registration');
    $routes->add('forgotpassword', 'Auth::forgotpassword');
    $routes->add('changepassword', 'Auth::changepassword');
    $routes->get('resetpassword', 'Auth::resetpassword');
    $routes->get('verify', 'Auth::verify');
    $routes->get('logout', 'Auth::logout');
});

$routes->group('/admin', static function ($routes){
    $routes->get('', 'Admin::index');
    $routes->add('role', 'Admin::role');
    $routes->add('role/(:num)', 'Admin::role/$1');
    $routes->get('roleaccess/(:num)', 'Admin::roleaccess/$1');
    $routes->add('changeaccess', 'Admin::changeaccess');
    $routes->delete('deleteRole/(:num)', 'Admin::deleteRole/$1');
    $routes->get('usermanagement', 'Admin::usermanagement');
    $routes->post('changeactivation', 'Admin::changeactivation');
    $routes->post('changerole', 'Admin::changerole');
});

$routes->group('/user', static function ($routes){
    $routes->get('', 'User::index');
    $routes->match(['GET', 'PUT'],'edit', 'User::edit');
    $routes->match(['GET', 'PUT'],'changepassword', 'User::changepassword');
});

$routes->group('/menu', static function ($routes){
    $routes->add('', 'Menu::index');
    $routes->add('(:num)', 'Menu::index/$1');
    $routes->add('submenu', 'Menu::submenu');
    $routes->add('submenu/(:num)', 'Menu::submenu/$1');
    $routes->delete('(:num)', 'Menu::deleteMenu/$1');
    $routes->delete('submenu/delete/(:num)', 'Menu::deleteSubmenu/$1');
});
