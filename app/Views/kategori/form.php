<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class='row justify-content-center'>
    <div class='col-md-8'>
        <div class='card shadow-sm'>
            <div class='card-header bg-primary text-white'>
                <h4 class='mb-0'><?= esc($title) ?></h4>
            </div>
            <div class='card-body'>
                
                <?php $action = $kategori ? base_url('kategori/update/' . $kategori['id']) : base_url('kategori/simpan'); ?>
                
                <form action='<?= $action ?>' method='POST'>
                    <?= csrf_field() ?>

                    <div class='mb-3'>
                        <label for='nama' class='form-label'>Nama Kategori <span class='text-danger'>*</span></label>
                        <input type='text' class='form-control' id='nama' name='nama' 
                               value='<?= old('nama', $kategori['nama'] ?? '') ?>' required autofocus>
                        <div class='form-text'>Nama kategori harus unik dan tidak boleh kosong.</div>
                    </div>

                    <div class='mb-3'>
                        <label for='deskripsi' class='form-label'>Deskripsi</label>
                        <textarea class='form-control' id='deskripsi' name='deskripsi' rows='4'><?= old('deskripsi', $kategori['deskripsi'] ?? '') ?></textarea>
                        <div class='form-text'>Opsional. Berikan penjelasan singkat tentang kategori ini.</div>
                    </div>

                    <hr>

                    <div class='d-flex justify-content-between'>
                        <a href='<?= base_url('kategori') ?>' class='btn btn-secondary'>
                            <i class='bi bi-arrow-left'></i> Kembali
                        </a>
                        <button type='submit' class='btn btn-primary'>
                            <i class='bi bi-save'></i> Simpan Kategori
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
