<?php
namespace App\Controllers\Admin;
 
use App\Controllers\BaseController;
use App\Models\BukuModel;
use App\Models\KategoriModel;
use App\Models\UserModel;
 
class Dashboard extends BaseController
{
    public function index(): string
    {
        // Load the custom app helper to make format_tanggal() available
        helper('app');

        $bukuModel     = new BukuModel();
        $kategoriModel = new KategoriModel();
        $userModel     = new UserModel();
 
        $db = \Config\Database::connect();
 
        $data = [
            'title'          => 'Dashboard Admin',
            'total_buku'     => $bukuModel->countAll(),
            'total_kategori' => $kategoriModel->countAll(),
            'total_user'     => $userModel->countAll(),
            'total_stok'     => (int)($db->table('buku')->selectSum('stok')->get()->getRow()->stok ?? 0),
            'buku_habis'     => $bukuModel->where('stok', 0)->countAllResults(),
            'user_terbaru'   => $userModel->orderBy('created_at','DESC')->limit(5)->findAll(),
            'buku_terbaru'   => $bukuModel->orderBy('created_at','DESC')->limit(5)->findAll(),
            'per_kategori'   => $db->table('buku')
                ->select('kategori.nama, COUNT(buku.id) AS jumlah, SUM(buku.stok) AS total_stok')
                ->join('kategori','kategori.id = buku.kategori_id','left')
                ->groupBy('buku.kategori_id')
                ->orderBy('jumlah','DESC')
                ->get()->getResultArray(),
        ];
        return view('admin/dashboard', $data);
    }
}
