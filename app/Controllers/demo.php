<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Demo extends BaseController
{
    public function index(): string
    {
        $data = [
            // String 
            'judul'       => 'Halaman Demo',

            // Integer 
            'tahun'       => date('Y'),

            // Array flat 
            'warna'       => ['merah', 'hijau', 'biru'],

            // Array asosiatif 
            'user'        => ['nama' => 'Budi', 'email' => 'budi@mail.com'],

            // Array of array (tabel/list data) 

            'produk'      => [
                ['id' => 1, 'nama' => 'Laptop', 'harga' => 8500000],
                ['id' => 2, 'nama' => 'Mouse',  'harga' => 150000],
                ['id' => 3, 'nama' => 'Keyboard', 'harga' => 350000],
            ],

            // Boolean 
            'show_footer' => true,

            // Null (optional data) 
            'promo'       => null,
        ];
        return view('demo/index', $data);
    }
}
