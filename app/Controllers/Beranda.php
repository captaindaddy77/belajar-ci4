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
     * Halaman beranda dengan statistik dan data dinamis 
     */
    public function index(): string
    {
        $data = [
            'title'       => 'Beranda',
            'sapaan'      => $this->getSapaan(),
            'statistik'   => [
                'total_buku'     => 150,
                'total_anggota'  => 87,
                'buku_dipinjam'  => 34,
                'buku_tersedia'  => 116,
            ],
            'buku_terbaru' => [
                [
                    'judul' => 'Clean Code',
                    'penulis' => 'Robert C. Martin',
                    'tahun' => 2008
                ],
                [
                    'judul' => 'Design Patterns',
                    'penulis' => 'Gang of Four',
                    'tahun' => 1994
                ],
                [
                    'judul' => 'The Pragmatic Programmer',
                    'penulis' => 'Hunt & Thomas',
                    'tahun' => 2019
                ],
            ],
        ];
        return view('beranda/index', $data);
    }

    public function tentang(): string
    {
        $data = [
            'title' => 'Tentang Sistem',
            'versi' => '1.0.0',
            'framework' => 'CodeIgniter 4',
            'fitur' => [
                'Manajemen koleksi buku',
                'Pendaftaran anggota',
                'Sistem peminjaman',
                'Laporan dan statistik',
                'Autentikasi pengguna',
            ],
        ];
        return view('beranda/tentang', $data);
    }

    /** 
     * Helper method — menentukan sapaan berdasarkan jam 
     */
    private function getSapaan(): string
    {
        $jam = (int) date('H');
        if ($jam >= 5 && $jam < 12)  return 'Selamat Pagi';
        if ($jam >= 12 && $jam < 15) return 'Selamat Siang';
        if ($jam >= 15 && $jam < 18) return 'Selamat Sore';
        return 'Selamat Malam';
    }
}
