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
$routes->get('buku/statistik',      'Buku::statistik');

// Route CRUD Kategori
$routes->get('kategori',                'Kategori::index');
$routes->get('kategori/tambah',         'Kategori::tambah');
$routes->post('kategori/simpan',        'Kategori::simpan');
$routes->get('kategori/edit/(:num)',    'Kategori::edit/$1');
$routes->post('kategori/update/(:num)', 'Kategori::update/$1');
$routes->get('kategori/hapus/(:num)',   'Kategori::hapus/$1');

// Route Akademik
$routes->get('akademik', 'Akademik::index');
$routes->get('akademik/matkul', 'Akademik::matkul');
$routes->get('akademik/nilai/(:any)', 'Akademik::nilai/$1');

// Route Profil
$routes->get('profil', 'Profil::index');
