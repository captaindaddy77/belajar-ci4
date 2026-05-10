<?php

namespace App\Controllers;

/** 
 * Controller Beranda - menangani halaman-halaman utama 
 * 
 * Semua Controller harus extends BaseController yang menyediakan 
 * helper method dan akses ke services CI4. 
 */
class Beranda extends BaseController
{
    /** 
     * Halaman beranda — diakses via GET / 
     */
    public function index(): string
    {
        // Saat ini kita return string langsung. 
        // Di pertemuan berikutnya, kita akan return view(). 
        return '<h1>Selamat Datang di Aplikasi CI4!</h1><p>Halaman Beranda</p>';
    }

    /** 
     * Halaman tentang — diakses via GET /tentang 
     */
    public function tentang(): string
    {
        return '<h1>Tentang Aplikasi</h1><p>Dibangun dengan CodeIgniter 4</p>';
    }

    /** 
     * Halaman dengan parameter — diakses via GET /pengguna/{id} 
     * 
     * @param int $id 
     */
    public function pengguna(int $id = 0): string
    {
        return "<h1>Profil Pengguna</h1> 
                <p>ID Pengguna: {$id}</p>";
    }

    /** 
     * Menampilkan tanggal & waktu server 
     */
    public function waktu(): string
    {
        $now = date('l, d F Y - H:i:s');
        return "<h1>Waktu Server</h1><p>Sekarang: {$now}</p>";
    }
}
