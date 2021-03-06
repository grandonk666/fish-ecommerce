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
$routes->setDefaultController('Home');
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
$routes->get('lang/{locale}', 'Language::index');

$routes->get('/', 'Home::index');
$routes->get('/about', 'Home::about');

$routes->get('/cart', 'Cart::index');
$routes->get('/cart/get_sum', 'Cart::get_sum');
$routes->post('/cart', 'Cart::insert');
$routes->post('/cart/update', 'Cart::update');
$routes->post('/cart/delete', 'Cart::delete');

$routes->get('/product', 'Product::index');
$routes->get('/product/(:any)', 'Product::detail/$1');

$routes->get('/checkout', 'Checkout::index');
$routes->get('/checkout/cities', 'Checkout::get_cities');
$routes->get('/checkout/costs', 'Checkout::get_costs');
$routes->post('/checkout/token', 'Checkout::get_token');
$routes->post('/checkout/finish', 'Checkout::finish');

$routes->get('/download/(:num)', 'Home::download/$1');

$routes->post('/transaction/notification', 'AdminTransaction::notification');

$routes->post('/international/save/(:any)', 'International::save/$1');
$routes->post('/international/payment', 'International::payment');
$routes->get('/international', 'International::index');
$routes->get('/international/(:any)', 'International::order/$1');

$routes->get('/profile', 'Profile::index');
$routes->post('/profile/update', 'Profile::update');
$routes->get('/profile/settings', 'Profile::edit');
$routes->get('/profile/transaction', 'Profile::transaction');
$routes->get('/profile/transaction/(:num)', 'Profile::transaction_detail/$1');
$routes->get('/profile/international', 'Profile::international_transaction');
$routes->get('/profile/international/(:num)', 'Profile::international_detail/$1');

$routes->group('/admin', ['filter' => 'role:admin'], function ($routes) {
	$routes->get('/', function () {
		return redirect()->to('/admin/product');
	});

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

	$routes->post('transaction/reciept', 'AdminTransaction::reciept');
	$routes->get('transaction', 'AdminTransaction::index');
	$routes->get('transaction/(:num)', 'AdminTransaction::detail/$1');

	$routes->post('international/invoice', 'AdminInternational::invoice');
	$routes->post('international/reciept', 'AdminInternational::reciept');
	$routes->get('international', 'AdminInternational::index');
	$routes->get('international/(:num)', 'AdminInternational::detail/$1');

	$routes->get('user', 'AdminUser::index');
	$routes->post('user/role/(:num)', 'AdminUser::role/$1');
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
