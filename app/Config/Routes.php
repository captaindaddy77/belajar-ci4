<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Route default (halaman beranda) 
$routes->get('/', 'Beranda::index');

// Route halaman tentang 
$routes->get('tentang', 'Beranda::tentang');

// Route controller Demo
$routes->get('demo', 'Demo::index');

// Route dengan parameter numerik 
$routes->get('pengguna/(:num)', 'Beranda::pengguna/$1');

// Route halaman waktu 
$routes->get('waktu', 'Beranda::waktu');
