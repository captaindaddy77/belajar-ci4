<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Pengguna extends BaseController
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /** Tampilkan daftar semua pengguna */
    public function index()
    {
        helper('app');
        $data = [
            'title' => 'Manajemen Pengguna',
            'users' => $this->userModel->getDaftarUser(),
        ];
        return view('admin/pengguna', $data);
    }

    /** Fitur aktifkan/nonaktifkan akun pengguna (toggle kolom aktif) */
    public function toggleAktif(int $id)
    {
        $currentAdminId = (int) session()->get('user_id');

        // Proteksi: admin tidak bisa menonaktifkan akun miliknya sendiri
        if ($id === $currentAdminId) {
            session()->setFlashdata('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri!');
            return redirect()->back();
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            session()->setFlashdata('error', 'Pengguna tidak ditemukan.');
            return redirect()->back();
        }

        $newStatus = $user['aktif'] == 1 ? 0 : 1;
        $this->userModel->update($id, ['aktif' => $newStatus]);

        $statusText = $newStatus == 1 ? 'diaktifkan' : 'dinonaktifkan';
        session()->setFlashdata('sukses', "Akun pengguna '{$user['username']}' berhasil {$statusText}.");
        return redirect()->back();
    }

    /** Fitur ubah role pengguna */
    public function ubahRole(int $id)
    {
        $currentAdminId = (int) session()->get('user_id');

        // Proteksi: admin tidak bisa mengubah role akun miliknya sendiri
        if ($id === $currentAdminId) {
            session()->setFlashdata('error', 'Anda tidak dapat mengubah role akun Anda sendiri!');
            return redirect()->back();
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            session()->setFlashdata('error', 'Pengguna tidak ditemukan.');
            return redirect()->back();
        }

        $newRole = $this->request->getPost('role');
        $allowedRoles = ['admin', 'petugas', 'anggota'];

        if (!in_array($newRole, $allowedRoles)) {
            session()->setFlashdata('error', 'Role tidak valid.');
            return redirect()->back();
        }

        $this->userModel->update($id, ['role' => $newRole]);

        session()->setFlashdata('sukses', "Role pengguna '{$user['username']}' berhasil diubah menjadi {$newRole}.");
        return redirect()->back();
    }
}
