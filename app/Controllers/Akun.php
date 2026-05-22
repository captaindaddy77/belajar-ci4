<?php
namespace App\Controllers;

use App\Models\UserModel;

class Akun extends BaseController
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /** Form ganti password. Hanya boleh diakses jika sudah login (lewat filter auth). */
    public function gantiPassword()
    {
        return view('akun/ganti_password', ['title' => 'Ganti Password']);
    }

    /** Proses ganti password */
    public function prosesGantiPassword()
    {
        $rules = [
            'password_lama' => [
                'label'  => 'Password Lama',
                'rules'  => 'required',
            ],
            'password_baru' => [
                'label'  => 'Password Baru',
                'rules'  => 'required|min_length[8]',
                'errors' => [
                    'min_length' => '{field} minimal {param} karakter.',
                ]
            ],
            'konfirmasi_password' => [
                'label'  => 'Konfirmasi Password Baru',
                'rules'  => 'required|matches[password_baru]',
                'errors' => [
                    'matches' => '{field} harus sama dengan Password Baru.',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            session()->setFlashdata('error', 'User tidak ditemukan.');
            return redirect()->to('/login');
        }

        $passwordLama = $this->request->getPost('password_lama');
        $passwordBaru = $this->request->getPost('password_baru');

        // Verifikasi password lama
        if (!password_verify($passwordLama, $user['password'])) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', ['password_lama' => 'Password lama tidak cocok dengan database.']);
        }

        // Simpan password baru
        $this->userModel->update($userId, [
            'password' => password_hash($passwordBaru, PASSWORD_DEFAULT),
        ]);

        session()->setFlashdata('sukses', 'Password Anda berhasil diganti!');
        return redirect()->to('/');
    }
}
