<?php
namespace App\Controllers;
 
use App\Models\UserModel;
 
class Auth extends BaseController
{
    private UserModel $userModel;
 
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
 
    /** Halaman login. Jika sudah login, redirect ke beranda. */
    public function login()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/');
        }
        
        // Cek lock status dan pasang flashdata jika sedang dikunci
        if (session()->getTempdata('login_locked')) {
            session()->setFlashdata('error', 'Akun dikunci selama 10 menit akibat terlalu banyak percobaan login.');
        }
        
        return view('auth/login', ['title' => 'Masuk ke Sistem']);
    }
  
    /** Proses autentikasi dari form login. */
    public function prosesLogin()
    {
        // Cek apakah session login sedang dikunci
        if (session()->getTempdata('login_locked')) {
            session()->setFlashdata('error', 'Akun dikunci selama 10 menit akibat terlalu banyak percobaan login.');
            return redirect()->to('/login');
        }

        $rules = [
            'identifier' => 'required|min_length[3]',
            'password'   => 'required|min_length[6]',
        ];
 
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                             ->with('errors', $this->validator->getErrors());
        }
 
        $identifier = $this->request->getPost('identifier');
        $password   = $this->request->getPost('password');
        $user = $this->userModel->cariUserAktif($identifier);
 
        // Gunakan pesan generik agar attacker tidak tahu
        // apakah username atau password yang salah (security best practice)
        $pesanError = 'Username/email atau password salah. Silakan coba lagi.';
 
        if (!$user || !password_verify($password, $user['password'])) {
            // Jika user tidak ada, tetap jalankan password_verify
            // untuk mencegah timing attack yang mengukur waktu respons
            if (!$user) password_verify($password, '$2y$12$dummy_hash_untuk_timing');
            
            // Hitung percobaan gagal
            $attempts = (int) session()->getTempdata('login_attempts') + 1;
            
            if ($attempts >= 5) {
                // Kunci login selama 10 menit (600 detik)
                session()->setTempdata('login_locked', true, 600);
                session()->removeTempdata('login_attempts');
                session()->setFlashdata('error', 'Akun dikunci selama 10 menit akibat terlalu banyak percobaan login.');
            } else {
                // Simpan jumlah percobaan gagal dengan TTL 10 menit (600 detik)
                session()->setTempdata('login_attempts', $attempts, 600);
                $sisa = 5 - $attempts;
                session()->setFlashdata('error', $pesanError . " (Sisa percobaan: {$sisa})");
            }
            
            return redirect()->to('/login');
        }
 
        // Login berhasil — reset hitungan rate limit
        session()->removeTempdata('login_attempts');
        session()->removeTempdata('login_locked');

        // Simpan data ke session
        session()->set([
            'user_id'   => $user['id'],
            'username'  => $user['username'],
            'nama'      => $user['nama_lengkap'],
            'email'     => $user['email'],
            'role'      => $user['role'],
            'logged_in' => true,
        ]);
 
        $this->userModel->catatLogin($user['id']);
 
        // Regenerasi session ID untuk mencegah session fixation attack
        session()->regenerate(true);
 
        // Redirect berdasarkan role
        $role = session()->get('role');

        if ($role === 'admin') {
            return redirect()->to('/admin');          // beranda admin
        } else {
            // Redirect ke halaman yang semula ingin diakses, atau beranda umum (anggota & petugas)
            $redirect = session()->getFlashdata('redirect_after_login') ?? '/';
            return redirect()->to($redirect);
        }
    }
 
    /** Hancurkan session dan redirect ke login. */
    public function logout()
    {
        $nama = session()->get('nama');
        session()->destroy();
        session()->setFlashdata('info', "Sampai jumpa, {$nama}! Anda telah logout.");
        return redirect()->to('/login');
    }
 
    /** Halaman registrasi akun baru. */
    public function register()
    {
        return view('auth/register', ['title' => 'Daftar Akun Baru']);
    } 
 
    /** Proses pendaftaran akun baru. */
    public function prosesRegister()
    {
        $rules = [
            'username' => [
                'label' => 'Username',
                'rules' => 'required|min_length[4]|max_length[50]|alpha_numeric|is_unique[users.username]',
                'errors'=> ['is_unique' => 'Username "{value}" sudah digunakan.'],
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email|max_length[100]|is_unique[users.email]',
                'errors'=> ['is_unique' => 'Email "{value}" sudah terdaftar.'],
            ],
            'nama_lengkap' => 'required|min_length[3]|max_length[100]',
            'password'     => [
                'label' => 'Password',
                'rules' => 'required|min_length[8]',
                'errors'=> ['min_length' => 'Password minimal {param} karakter.'],
            ],
            'konfirmasi'   => [
                'label' => 'Konfirmasi Password',
                'rules' => 'required|matches[password]',
                'errors'=> ['matches' => 'Konfirmasi password tidak cocok.'],
            ],
        ];
 
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                             ->with('errors', $this->validator->getErrors());
        }
 
        $this->userModel->insert([
            'username'     => $this->request->getPost('username'),
            'email'        => $this->request->getPost('email'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'password'     => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'         => 'anggota',
        ]);
 
        session()->setFlashdata('sukses', 'Akun berhasil dibuat! Silakan login.');
        return redirect()->to('/login');
    }
}
