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

// Route CRUD Buku 
$routes->get('buku',                'Buku::index');
$routes->get('buku/tambah',         'Buku::tambah');
$routes->post('buku/simpan',        'Buku::simpan');
$routes->get('buku/detail/(:num)',  'Buku::detail/$1');
$routes->get('buku/edit/(:num)',    'Buku::edit/$1');
$routes->post('buku/update/(:num)', 'Buku::update/$1');
$routes->get('buku/hapus/(:num)',   'Buku::hapus/$1');
$routes->get('buku/ekspor',         'Buku::ekspor');

// Route Akademik
$routes->get('akademik', 'Akademik::index');
$routes->get('akademik/matkul', 'Akademik::matkul');
$routes->get('akademik/nilai/(:any)', 'Akademik::nilai/$1');

// Route Profil
$routes->get('profil', 'Profil::index');
