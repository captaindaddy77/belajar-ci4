<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table            = 'kategori';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama', 'deskripsi'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /** 
     * Ambil semua kategori sebagai dropdown options 
     * Return: ['id' => 'nama'] untuk form select 
     */
    public function getDropdown(): array
    {
        $kategori = $this->orderBy('nama')->findAll();
        $result = ['' => '-- Pilih Kategori --'];
        foreach ($kategori as $k) {
            $result[$k['id']] = $k['nama'];
        }
        return $result;
    }

    /**
     * Ambil semua kategori beserta jumlah buku di masing-masing kategori
     */
    public function getKategoriDenganJumlahBuku(): array
    {
        return $this->select('kategori.*, COUNT(buku.id) AS jumlah_buku')
                    ->join('buku', 'buku.kategori_id = kategori.id', 'left')
                    ->groupBy('kategori.id')
                    ->orderBy('kategori.nama', 'ASC')
                    ->findAll();
    }

    /**
     * Cek apakah nama kategori sudah digunakan (untuk validasi unik)
     */
    public function isNamaTaken(string $nama, int $excludeId = 0): bool
    {
        $qb = $this->where('nama', $nama);
        if ($excludeId > 0) {
            $qb->where('id !=', $excludeId);
        }
        return $qb->countAllResults() > 0;
    }

    /**
     * Cek apakah kategori digunakan oleh tabel buku
     */
    public function isDigunakan(int $id): bool
    {
        $db = \Config\Database::connect();
        return $db->table('buku')->where('kategori_id', $id)->countAllResults() > 0;
    }
}
