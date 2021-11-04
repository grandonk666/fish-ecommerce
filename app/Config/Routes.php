<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Hotel');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/about', 'Home::about');

$routes->get('/product', 'Product::index');
$routes->get('/product/(:any)', 'Product::detail/$1');

$routes->get('/checkout', 'Checkout::index');
$routes->get('/checkout/token', 'Checkout::get_token');
$routes->post('/checkout/finish', 'Checkout::finish');

$routes->get('/download/(:num)', 'Home::download/$1');

$routes->get('/profile', 'Profil::index');
$routes->get('/profile/settings', 'Profil::edit');
$routes->get('/profile/transaksi', 'Profil::transaksi');
$routes->post('/profile/transaksi', 'Profil::transaksi');
$routes->get('/profile/order/(:num)', 'Profil::order/$1');

$routes->group('/admin', ['filter' => 'role:admin'], function ($routes) {
	$routes->get('/', 'Dashboard::index');

	$routes->get('product', 'AdminProduct::index');
	$routes->post('product/save', 'AdminProduct::save');
	$routes->post('product/update/(:num)', 'AdminProduct::update/$1');
	$routes->get('product/create', 'AdminProduct::create');
	$routes->get('product/edit/(:any)', 'AdminProduct::edit/$1');
	$routes->delete('product/(:num)', 'AdminProduct::delete/$1');
	$routes->get('product/(:any)', 'AdminProduct::detail/$1');

	$routes->get('category', 'AdminCategory::index');
	$routes->post('category/save', 'AdminCategory::save');
	$routes->post('category/update/(:num)', 'AdminCategory::update/$1');
	$routes->get('category/create', 'AdminCategory::create');
	$routes->get('category/edit/(:any)', 'AdminCategory::edit/$1');
	$routes->delete('category/(:num)', 'AdminCategory::delete/$1');
	$routes->get('category/(:any)', 'AdminCategory::detail/$1');

	$routes->get('transaksi', 'Transaksi::index');
	$routes->post('transaksi', 'Transaksi::index');

	$routes->get('user', 'User::index');
	$routes->get('user/(:num)', 'User::detail/$1');
	$routes->post('user/role/(:num)', 'User::role/$1');
	$routes->delete('user/(:num)', 'User::delete/$1');
});


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
