<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Akademik extends BaseController
{
    // Method untuk menampilkan judul dan nama
    public function index()
    {
        echo "<h1>Sistem Informasi Akademik</h1>";
        echo "<p>Nama Mahasiswa: Muhammad Nabil Zaky</p>";
    }

    // Method untuk menampilkan daftar 5 mata kuliah
    public function matkul()
    {
        $daftar_matkul = [
            "Pemrograman Web Lanjut",
            "Basis Data",
            "Sistem Operasi",
            "Jaringan Komputer",
            "Rekayasa Perangkat Lunak"
        ];

        echo "<h3>Daftar Mata Kuliah Semester 6:</h3>";
        echo "<ul>";
        foreach ($daftar_matkul as $mk) {
            echo "<li>$mk</li>";
        }
        echo "</ul>";
    }

    // Method dengan parameter NIM
    public function nilai($nim)
    {
        echo "Nilai mahasiswa dengan NIM: " . esc($nim);
    }
}
