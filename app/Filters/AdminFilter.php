<?php 
namespace App\Filters; 
  
use CodeIgniter\HTTP\RequestInterface; 
use CodeIgniter\HTTP\ResponseInterface; 
use CodeIgniter\Filters\FilterInterface; 
  
/** 
 * AdminFilter — memastikan pengguna memiliki role yang diizinkan. 
 * Gunakan setelah AuthFilter. Contoh penggunaan dengan argumen: 
 *   ['filter' => 'role:admin']         hanya admin 
 *   ['filter' => 'role:admin,petugas'] admin atau petugas 
 */ 
class AdminFilter implements FilterInterface 
{ 
    public function before(RequestInterface $request, $arguments = null) 
    { 
        $role = session()->get('role'); 
        // Jika ada argumen spesifik, cek apakah role termasuk 
        if (!empty($arguments) && !in_array($role, $arguments)) { 
            session()->setFlashdata('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.'); 
            return redirect()->to('/'); 
        } 
  
        // Tanpa argumen: izinkan admin dan petugas saja 
        if (empty($arguments) && !in_array($role, ['admin', 'petugas'])) { 
            session()->setFlashdata('error', 'Halaman ini hanya untuk admin dan petugas.'); 
            return redirect()->to('/'); 
        } 
    } 
  
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {} 
} 
