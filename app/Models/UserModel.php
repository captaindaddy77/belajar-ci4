<?php 
namespace App\Models; 
  
use CodeIgniter\Model; 
  
class UserModel extends Model 
{ 
    protected $table         = 'users'; 
    protected $primaryKey    = 'id'; 
    protected $returnType    = 'array'; 
    protected $useTimestamps = true; 
    protected $allowedFields = [ 
        'username', 'email', 'password', 
        'nama_lengkap', 'role', 'aktif', 'last_login' 
    ]; 
  
    /** 
     * Cari user aktif berdasarkan username ATAU email. 
     * Mendukung login dengan keduanya. 
     */ 
    public function cariUserAktif(string $identifier): ?array 
    { 
        return $this 
            ->where('aktif', 1) 
            ->groupStart() 
                ->where('username', $identifier) 
                ->orWhere('email', $identifier) 
            ->groupEnd() 
            ->first(); 
    } 
  
    /** 
     * Perbarui waktu login terakhir pengguna. 
     */ 
    public function catatLogin(int $userId): void 
    { 
        $this->update($userId, ['last_login' => date('Y-m-d H:i:s')]); 
    } 
  
    /** 
     * Ambil semua user untuk halaman manajemen (tanpa password). 
     */ 
    public function getDaftarUser(): array 
    { 
        return $this 
            ->select('id, username, email, nama_lengkap, role, aktif, last_login, created_at') 
            ->orderBy('created_at', 'DESC') 
            ->findAll(); 
    } 
} 
