<?php

namespace App\Controllers;

use App\Models\BukuModel;
use App\Models\KategoriModel;

class Buku extends BaseController
{
    private BukuModel $bukuModel;
    private KategoriModel $kategoriModel;

    public function __construct()
    {
        $this->bukuModel     = new BukuModel();
        $this->kategoriModel = new KategoriModel();
    }

    // ────────────────────────────────────── 
    // READ - Daftar Buku dengan Search & Paginasi 
    // ────────────────────────────────────── 
    public function index(): string
    {
        $keyword  = $this->request->getGet('q') ?? '';
        $perPage  = 10;
        $buku     = $this->bukuModel->getBukuPaginate($perPage, $keyword);
        $pager    = $this->bukuModel->pager;

        $data = [
            'title'   => 'Daftar Buku',
            'buku'    => $buku,
            'pager'   => $pager,
            'keyword' => $keyword,
            'total'   => $this->bukuModel->countAllResults(false),
        ];
        return view('buku/index', $data);
    }

    // ────────────────────────────────────── 
    // READ - Detail satu buku 
    // ────────────────────────────────────── 
    public function detail(int $id): string
    {
        $buku = $this->bukuModel
            ->select('buku.*, kategori.nama AS nama_kategori')
            ->join('kategori', 'kategori.id = buku.kategori_id', 'left')
            ->find($id);

        if (!$buku) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Buku tidak ditemukan');
        }

        return view('buku/detail', ['title' => 'Detail Buku', 'buku' => $buku]);
    }

    // ────────────────────────────────────── 
    // CREATE - Form tambah 
    // ────────────────────────────────────── 
    public function tambah(): string
    {
        return view('buku/form', [
            'title'     => 'Tambah Buku',
            'buku'      => null,
            'kategori'  => $this->kategoriModel->getDropdown(),
        ]);
    }

    // ────────────────────────────────────── 
    // CREATE - Proses simpan 
    // ────────────────────────────────────── 
    public function simpan()
    {
        $rules = [
            'kode_buku' => [
                'label'  => 'Kode Buku',
                'rules'  =>
                'required|min_length[3]|max_length[20]|alpha_numeric|is_unique[buku.kode_buku]',
                'errors' => [
                    'required'      => '{field} wajib diisi.',
                    'alpha_numeric' => '{field} hanya boleh berisi huruf dan angka.',
                    'is_unique'     => 'Kode "{value}" sudah digunakan buku lain.',
                ],
            ],
            'judul' => [
                'label' => 'Judul Buku',
                'rules' => 'required|min_length[2]|max_length[200]',
            ],
            'penulis' => [
                'label' => 'Penulis',
                'rules' => 'required|min_length[2]|max_length[150]',
            ],
            'tahun' => [
                'label' => 'Tahun Terbit',
                'rules' => 'permit_empty|integer|greater_than[1499]|less_than[2100]',
                'errors' => [
                    'greater_than' => '{field} tidak boleh sebelum tahun 1500.',
                    'less_than'    => '{field} tidak boleh lebih dari tahun 2099.',
                ],
            ],
            'stok' => [
                'label' => 'Stok',
                'rules' => 'required|integer|greater_than_equal_to[0]',
                'errors' => [
                    'greater_than_equal_to' => '{field} tidak boleh bernilai negatif.',
                ],
            ],
            'isbn' => [
                'label' => 'ISBN',
                'rules' => 'permit_empty|min_length[10]|max_length[20]',
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = $this->ambilDataForm();
        $this->bukuModel->insert($data);
        session()->setFlashdata('sukses', "Buku '{$data['judul']}' berhasil ditambahkan.");
        return redirect()->to('/buku');
    }

    // ────────────────────────────────────── 
    // UPDATE - Form edit 
    // ────────────────────────────────────── 
    public function edit(int $id): string
    {
        $buku = $this->bukuModel->find($id);
        if (!$buku) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Buku tidak
ditemukan');
        }
        return view('buku/form', [
            'title' => 'Edit Buku: ' . $buku['judul'],
            'buku' => $buku,
            'kategori' => $this->kategoriModel->getDropdown(),
        ]);
    }

    // ────────────────────────────────────── 
    // UPDATE - Proses update 
    // ────────────────────────────────────── 
    public function update(int $id) 
    { 
        // is_unique dengan pengecualian: kode buku milik buku yang sedang diedit 
        $rules = [ 
            'kode_buku' => [ 
                'label'  => 'Kode Buku', 
                'rules'  =>
    "required|min_length[3]|max_length[20]|is_unique[buku.kode_buku,id,{$id}]", 
                'errors' => [ 
                    'is_unique' => 'Kode "{value}" sudah digunakan buku lain.', 
                ], 
            ], 
            'judul'   => 'required|min_length[2]|max_length[200]', 
            'penulis' => 'required|min_length[2]|max_length[150]', 
            'tahun'   => 'permit_empty|integer|greater_than[1499]|less_than[2100]', 
            'stok'    => 'required|integer|greater_than_equal_to[0]', 
            'isbn'    => 'permit_empty|min_length[10]|max_length[20]', 
        ]; 
      
        if (!$this->validate($rules)) { 
            return redirect()->back() 
                             ->withInput() 
                             ->with('errors', $this->validator->getErrors()); 
        } 
      
        $data = $this->ambilDataForm(); 
        $this->bukuModel->update($id, $data); 
        session()->setFlashdata('sukses', "Buku '{$data['judul']}' berhasil diperbarui."); 
        return redirect()->to('/buku'); 
    }

    // ────────────────────────────────────── 
    // DELETE 
    // ────────────────────────────────────── 
    public function hapus(int $id)
    {
        $buku = $this->bukuModel->find($id);
        if (!$buku) {
            session()->setFlashdata('error', 'Buku tidak ditemukan.');
            return redirect()->to('/buku');
        }

        $this->bukuModel->delete($id);
        session()->setFlashdata('sukses', "Buku '{$buku['judul']}' berhasil dihapus.");
        return redirect()->to('/buku');
    }

    // ────────────────────────────────────── 
    // STATISTIK - Halaman statistik buku
    // ────────────────────────────────────── 
    public function statistik(): string
    {
        $stat = $this->bukuModel->getStatistik();

        return view('buku/statistik', [
            'title' => 'Statistik Buku',
            'stat'  => $stat,
        ]);
    }

    // ────────────────────────────────────── 
    // EKSPOR - Generate CSV
    // ────────────────────────────────────── 
    public function ekspor()
    {
        $semua = $this->bukuModel->getBukuDenganKategori();

        $namaFile = 'buku-export-' . date('Y-m-d') . '.csv';

        $output = fopen('php://temp', 'r+');

        // Header kolom
        fputcsv($output, ['No', 'Kode', 'Judul', 'Penulis', 'Penerbit', 'Tahun', 'Stok', 'Kategori']);

        // Data baris
        foreach ($semua as $i => $b) {
            fputcsv($output, [
                $i + 1,
                $b['kode_buku'],
                $b['judul'],
                $b['penulis'],
                $b['penerbit'] ?? '',
                $b['tahun'] ?? '',
                $b['stok'],
                $b['nama_kategori'] ?? '',
            ]);
        }

        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);

        return response()
            ->setStatusCode(200)
            ->setContentType('text/csv')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $namaFile . '"')
            ->setBody($csv);
    }

    // ────────────────────────────────────── 
    // PRIVATE HELPER - Kumpulkan data dari form 
    // ────────────────────────────────────── 
    private function ambilDataForm(): array
    {
        return [
            'kode_buku'   => strtoupper($this->request->getPost('kode_buku')),
            'judul'       => $this->request->getPost('judul'),
            'penulis'     => $this->request->getPost('penulis'),
            'penerbit'    => $this->request->getPost('penerbit'),
            'tahun'       => $this->request->getPost('tahun') ?: null,
            'isbn'        => $this->request->getPost('isbn'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'stok'        => (int) $this->request->getPost('stok'),
            'kategori_id' => $this->request->getPost('kategori_id') ?: null,
        ];
    }
}
