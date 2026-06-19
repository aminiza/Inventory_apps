<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/login', 'Auth::login');
$routes->post('/auth/authenticate', 'Auth::authenticate');
$routes->get('/logout', 'Auth::logout');

$routes->get('/', 'Home::index', ['filter' => 'role:admin,petugas']);

$routes->get('test/search', 'Test::searchTest');

$routes->group('admin', ['filter' => 'role:admin'], function($routes) {
    // Rute CRUD Barang
    $routes->get('barang', 'Admin\Barang::index');
    $routes->get('barang/create', 'Admin\Barang::create');
    $routes->post('barang/store', 'Admin\Barang::store');
    $routes->get('barang/edit/(:num)', 'Admin\Barang::edit/$1');
    $routes->post('barang/update/(:num)', 'Admin\Barang::update/$1');
    $routes->get('barang/detail/(:num)', 'Admin\Barang::detail/$1');
    $routes->get('barang/delete/(:num)', 'Admin\Barang::delete/$1');

    // Rute CRUD kategori
    $routes->get('kategori', 'Admin\Kategori::index');
    $routes->post('kategori/store', 'Admin\Kategori::store');
    $routes->post('kategori/update/(:num)', 'Admin\Kategori::update/$1');
    $routes->get('kategori/delete/(:num)', 'Admin\Kategori::delete/$1');
});

// $routes->get('/stok', 'Petugas\Stok::index', ['filter' => 'role:petugas,admin']);

$routes->group('petugas', ['filter' => 'role:petugas,admin'], static function($routes) {
    // Rute CRUD Stok
    $routes->get('stok', 'Petugas\Stok::index');
    $routes->get('stok/create', 'Petugas\Stok::create');
    
    $routes->get('stok/search', 'Petugas\Stok::search');
    
    $routes->post('stok/store', 'Petugas\Stok::store');
    $routes->get('stok/edit/(:num)', 'Petugas\Stok::edit/$1');
    $routes->post('stok/update/(:num)', 'Petugas\Stok::update/$1');
    $routes->get('stok/delete/(:num)', 'Petugas\Stok::delete/$1');
});

$routes->get('/barang', 'Petugas\Barang::index', ['filter' => 'role:petugas']);