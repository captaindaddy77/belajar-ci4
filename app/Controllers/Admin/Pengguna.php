<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Pengguna extends BaseController
{
    public function index()
    {
        helper('app');
        $userModel = new UserModel();
        $data = [
            'title' => 'Manajemen Pengguna',
            'users' => $userModel->getDaftarUser(),
        ];
        return view('admin/pengguna', $data);
    }
}
