<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class='row justify-content-center'>
    <div class='col-md-6 col-lg-5'>
        <div class='card shadow-sm border-0 rounded-3'>
            <div class='card-header bg-primary text-white text-center py-3'>
                <h4 class='mb-0'><i class='bi bi-key-fill'></i> Ganti Password</h4>
                <small>Silakan masukkan password lama Anda dan password baru</small>
            </div>
            <div class='card-body p-4'>

                <?php $errors = session()->getFlashdata('errors') ?? []; ?>
                <?php if (!empty($errors)): ?>
                <div class='alert alert-danger py-2'>
                    <h6 class='alert-heading mb-1 small fw-bold'><i class='bi bi-exclamation-triangle-fill'></i> Gagal mengganti password:</h6>
                    <ul class='mb-0 ps-3 small'>
                    <?php foreach ($errors as $e): ?>
                        <li><?= esc($e) ?></li>
                    <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class='alert alert-danger py-2'>
                        <div class='small'><i class='bi bi-x-circle-fill'></i> <?= esc(session()->getFlashdata('error')) ?></div>
                    </div>
                <?php endif; ?>

                <form action='<?= base_url('akun/proses-ganti-password') ?>' method='post'>
                    <?= csrf_field() ?>

                    <!-- Password Lama -->
                    <div class='mb-3'>
                        <label class='form-label fw-bold small text-secondary'>PASSWORD LAMA <span class='text-danger'>*</span></label>
                        <div class='input-group'>
                            <span class='input-group-text bg-light'><i class='bi bi-shield-lock'></i></span>
                            <input type='password' name='password_lama' id='old_pwd' 
                                   class='form-control <?= isset($errors['password_lama']) ? 'is-invalid' : '' ?>' 
                                   placeholder='Masukkan password saat ini' required>
                            <button type='button' class='btn btn-outline-secondary border-secondary-subtle' 
                                    onclick="var x=document.getElementById('old_pwd'); x.type=x.type==='password'?'text':'password'">
                                <i class='bi bi-eye'></i>
                            </button>
                        </div>
                    </div>

                    <hr class='text-muted my-3'>

                    <!-- Password Baru -->
                    <div class='mb-3'>
                        <label class='form-label fw-bold small text-secondary'>PASSWORD BARU <span class='text-danger'>*</span></label>
                        <div class='input-group'>
                            <span class='input-group-text bg-light'><i class='bi bi-key'></i></span>
                            <input type='password' name='password_baru' id='new_pwd' 
                                   class='form-control <?= isset($errors['password_baru']) ? 'is-invalid' : '' ?>' 
                                   placeholder='Minimal 8 karakter' required>
                            <button type='button' class='btn btn-outline-secondary border-secondary-subtle' 
                                    onclick="var x=document.getElementById('new_pwd'); x.type=x.type==='password'?'text':'password'">
                                <i class='bi bi-eye'></i>
                            </button>
                        </div>
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class='mb-4'>
                        <label class='form-label fw-bold small text-secondary'>KONFIRMASI PASSWORD BARU <span class='text-danger'>*</span></label>
                        <div class='input-group'>
                            <span class='input-group-text bg-light'><i class='bi bi-check2-circle'></i></span>
                            <input type='password' name='konfirmasi_password' id='confirm_pwd' 
                                   class='form-control <?= isset($errors['konfirmasi_password']) ? 'is-invalid' : '' ?>' 
                                   placeholder='Ulangi password baru Anda' required>
                            <button type='button' class='btn btn-outline-secondary border-secondary-subtle' 
                                    onclick="var x=document.getElementById('confirm_pwd'); x.type=x.type==='password'?'text':'password'">
                                <i class='bi bi-eye'></i>
                            </button>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class='d-flex gap-2'>
                        <button type='submit' class='btn btn-primary w-100 py-2 fw-semibold'>
                            <i class='bi bi-save2'></i> Perbarui Password
                        </button>
                        <a href='<?= base_url('/') ?>' class='btn btn-secondary py-2 px-3'>
                            Batal
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
