<?php

namespace App\Controllers;

use App\Models\KategoriModel;

class Kategori extends BaseController
{
    private KategoriModel $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
    }

    // ────────────────────────────────────── 
    // READ - Daftar Kategori
    // ────────────────────────────────────── 
    public function index(): string
    {
        $kategori = $this->kategoriModel->getKategoriDenganJumlahBuku();

        $data = [
            'title'    => 'Daftar Kategori',
            'kategori' => $kategori,
        ];
        return view('kategori/index', $data);
    }

    // ────────────────────────────────────── 
    // CREATE - Form tambah 
    // ────────────────────────────────────── 
    public function tambah(): string
    {
        return view('kategori/form', [
            'title'    => 'Tambah Kategori',
            'kategori' => null,
        ]);
    }

    // ────────────────────────────────────── 
    // CREATE - Proses simpan 
    // ────────────────────────────────────── 
    public function simpan()
    {
        $nama      = $this->request->getPost('nama');
        $deskripsi = $this->request->getPost('deskripsi');

        if (empty(trim($nama))) {
            session()->setFlashdata('error', 'Nama kategori tidak boleh kosong.');
            return redirect()->back()->withInput();
        }

        // Validasi nama unik 
        if ($this->kategoriModel->isNamaTaken($nama)) {
            session()->setFlashdata('error', 'Nama kategori sudah digunakan.');
            return redirect()->back()->withInput();
        }

        $this->kategoriModel->insert([
            'nama'      => $nama,
            'deskripsi' => $deskripsi,
        ]);
        session()->setFlashdata('sukses', "Kategori '{$nama}' berhasil ditambahkan.");
        return redirect()->to('/kategori');
    }

    // ────────────────────────────────────── 
    // UPDATE - Form edit 
    // ────────────────────────────────────── 
    public function edit(int $id): string
    {
        $kategori = $this->kategoriModel->find($id);
        if (!$kategori) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kategori tidak ditemukan');
        }

        return view('kategori/form', [
            'title'    => 'Edit Kategori: ' . $kategori['nama'],
            'kategori' => $kategori,
        ]);
    }

    // ────────────────────────────────────── 
    // UPDATE - Proses update 
    // ────────────────────────────────────── 
    public function update(int $id)
    {
        $nama      = $this->request->getPost('nama');
        $deskripsi = $this->request->getPost('deskripsi');

        if (empty(trim($nama))) {
            session()->setFlashdata('error', 'Nama kategori tidak boleh kosong.');
            return redirect()->back()->withInput();
        }

        // Validasi nama unik, kecuali kategori yang sedang diedit  
        if ($this->kategoriModel->isNamaTaken($nama, $id)) {
            session()->setFlashdata('error', 'Nama kategori sudah digunakan oleh kategori lain.');
            return redirect()->back()->withInput();
        }

        $this->kategoriModel->update($id, [
            'nama'      => $nama,
            'deskripsi' => $deskripsi,
        ]);
        session()->setFlashdata('sukses', "Kategori '{$nama}' berhasil diperbarui.");
        return redirect()->to('/kategori');
    }

    // ────────────────────────────────────── 
    // DELETE 
    // ────────────────────────────────────── 
    public function hapus(int $id)
    {
        $kategori = $this->kategoriModel->find($id);
        if (!$kategori) {
            session()->setFlashdata('error', 'Kategori tidak ditemukan.');
            return redirect()->to('/kategori');
        }

        // Cek jika kategori masih digunakan
        if ($this->kategoriModel->isDigunakan($id)) {
            session()->setFlashdata('error', "Kategori '{$kategori['nama']}' gagal dihapus karena masih memiliki buku terkait.");
            return redirect()->to('/kategori');
        }

        $this->kategoriModel->delete($id);
        session()->setFlashdata('sukses', "Kategori '{$kategori['nama']}' berhasil dihapus.");
        return redirect()->to('/kategori');
    }
}
