<?= $this->extend('layout/main') ?> 
<?= $this->section('content') ?> 
  
<div class='row justify-content-center'> 
    <div class='col-md-7 col-lg-6'> 
        <div class='card shadow'> 
            <div class='card-header bg-primary text-white py-3'> 
                <h4 class='mb-0'><i class='bi bi-person-plus'></i> Daftar Akun Baru</h4> 
            </div> 
            <div class='card-body p-4'> 
  
                <?php $errors = session()->getFlashdata('errors') ?? []; ?> 
                <?php if (!empty($errors)): ?> 
                    <div class='alert alert-danger'> 
                        <ul class='mb-0 ps-3'> 
                            <?php foreach ($errors as $e): ?> 
                                <li><?= esc($e) ?></li> 
                            <?php endforeach; ?> 
                        </ul> 
                    </div> 
                <?php endif; ?> 
  
                <form action='<?= base_url('register/proses') ?>' method='post'> 
                    <?= csrf_field() ?> 
                    <div class='row'> 
                        <div class='col-md-6 mb-3'> 
                            <label class='form-label fw-bold'>Username *</label> 
                            <input type='text' name='username' class='form-control' 
                                   value='<?= esc(old('username')) ?>' 
                                   placeholder='Min. 4 karakter' required> 
                            <small class='text-muted'>Hanya huruf dan angka, tanpa spasi.</small> 
                        </div> 
                        <div class='col-md-6 mb-3'> 
                            <label class='form-label fw-bold'>Email *</label> 
                            <input type='email' name='email' class='form-control' 
                                   value='<?= esc(old('email')) ?>' required> 
                        </div> 
                    </div> 
                    <div class='mb-3'> 
                        <label class='form-label fw-bold'>Nama Lengkap *</label> 
                        <input type='text' name='nama_lengkap' class='form-control' 
                               value='<?= esc(old('nama_lengkap')) ?>' required> 
                    </div> 
                    <div class='row'> 
                        <div class='col-md-6 mb-3'> 
                            <label class='form-label fw-bold'>Password *</label> 
                            <input type='password' name='password' class='form-control' 
                                   placeholder='Min. 8 karakter' required> 
                        </div> 
                        <div class='col-md-6 mb-3'> 
                            <label class='form-label fw-bold'>Konfirmasi Password *</label> 
                            <input type='password' name='konfirmasi' class='form-control' required>
                        </div> 
                    </div> 
                    <button type='submit' class='btn btn-primary w-100'> 
                        <i class='bi bi-person-check'></i> Buat Akun 
                    </button> 
                </form> 
                <hr> 
                <p class='text-center mb-0 small'> 
                    Sudah punya akun? <a href='<?= base_url('login') ?>'>Login di sini</a> 
                </p> 
            </div> 
        </div> 
    </div> 
</div> 
  
<?= $this->endSection() ?>
