<?php

namespace App\Controllers;

class Profil extends BaseController
{
    public function index()
    {
        $data = [
            'npm' => '2310010511',
            'nama' => 'Muhammad Nabil Zaky',
            'prodi' => 'Teknik Informatika',
            'angkatan' => '2023',
            'ipk' => 3.66,
            'matkul' => [
                'Pemrograman Web Lanjut',
                'Basis Data',
                'Sistem Operasi',
                'Jaringan Komputer',
                'Rekayasa Perangkat Lunak'
            ]
        ];

        return view('profil', $data);
    }
}
