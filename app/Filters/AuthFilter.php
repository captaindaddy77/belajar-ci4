<?php 
namespace App\Filters; 
  
use CodeIgniter\HTTP\RequestInterface; 
use CodeIgniter\HTTP\ResponseInterface; 
use CodeIgniter\Filters\FilterInterface; 
  
/** 
 * AuthFilter - memastikan pengguna sudah login. 
 * Jika belum, redirect ke halaman login. 
 */ 
class AuthFilter implements FilterInterface 
{ 
    public function before(RequestInterface $request, $arguments = null) 
    { 
        if (!session()->get('logged_in')) { 
            // Simpan URL tujuan agar setelah login bisa langsung diarahkan ke sana 
            session()->setFlashdata('redirect_after_login', (string) current_url()); 
            session()->setFlashdata('error', 'Silakan login terlebih dahulu untuk mengakses halaman ini.'); 
            return redirect()->to('/login'); 
        } 
    } 
  
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {} 
} 
