<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
 
<div class='row justify-content-center mt-3'>
    <div class='col-md-5 col-lg-4'>
        <div class='card shadow'>
            <div class='card-header bg-primary text-white text-center py-3'>
                <h4 class='mb-0'><i class='bi bi-person-circle'></i> Login</h4>
                <small>Sistem Perpustakaan Digital</small>
            </div>
            <div class='card-body p-4'>
 
                <?php $errors = session()->getFlashdata('errors') ?? []; ?>
                <?php if (!empty($errors)): ?>
                    <div class='alert alert-danger py-2'>
                        <?php foreach ($errors as $e): ?>
                            <div><i class='bi bi-x-circle'></i> <?= esc($e) ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class='alert alert-danger py-2'>
                        <div><i class='bi bi-exclamation-triangle'></i> <?= esc(session()->getFlashdata('error')) ?></div>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('sukses')): ?>
                    <div class='alert alert-success py-2'>
                        <div><i class='bi bi-check-circle'></i> <?= esc(session()->getFlashdata('sukses')) ?></div>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('info')): ?>
                    <div class='alert alert-info py-2'>
                        <div><i class='bi bi-info-circle'></i> <?= esc(session()->getFlashdata('info')) ?></div>
                    </div>
                <?php endif; ?>
 
                <form action='<?= base_url('login/proses') ?>' method='post'>
                    <?= csrf_field() ?>
 
                    <div class='mb-3'>
                        <label class='form-label fw-bold'>Username atau Email</label>
                        <div class='input-group'>
                            <span class='input-group-text'><i class='bi bi-person'></i></span>
                            <input type='text' name='identifier' class='form-control' value='<?= esc(old('identifier')) ?>' placeholder='Username atau email' required autofocus>
                        </div>
                    </div>
 
                    <div class='mb-3'>
                        <label class='form-label fw-bold'>Password</label>
                        <div class='input-group'>
                            <span class='input-group-text'><i class='bi bi-lock'></i></span>
                            <input type='password' name='password' id='pwd' class='form-control' placeholder='Password' required>
                            <button type='button' class='btn btn-outline-secondary' onclick="var x=document.getElementById('pwd'); x.type=x.type==='password'?'text':'password'">
                                <i class='bi bi-eye'></i>
                            </button>
                        </div>
                    </div>
 
                    <button type='submit' class='btn btn-primary w-100 py-2'>
                        <i class='bi bi-box-arrow-in-right'></i> Masuk
                    </button>
                </form>
                <hr>
                <p class='text-center mb-0 small'>
                    Belum punya akun? <a href='<?= base_url('register') ?>'>Daftar sekarang</a>
                </p>
            </div>
        </div>
    </div>
</div>
 
<?= $this->endSection() ?>
