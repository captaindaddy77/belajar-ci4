<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?php $isEdit = !is_null($buku); ?>

<div class='row justify-content-center'>
    <div class='col-md-9'>
        <div class='card shadow-sm'>
            <div class='card-header bg-primary text-white'>
                <h4 class='mb-0'>
                    <i class='bi bi-<?= $isEdit ? 'pencil' : 'plus-circle' ?>'></i>
                    <?= esc($title) ?>
                </h4>
            </div>
            <div class='card-body'>

                <!-- Error dari session -->
                <?php if (session()->getFlashdata('error')): ?>
                    <div class='alert alert-danger'>
                        <?= esc(session()->getFlashdata('error')) ?>
                    </div>
                <?php endif; ?>

                <form action='<?= base_url($isEdit ? 'buku/update/' . $buku['id'] :
                                    'buku/simpan') ?>'
                    method='post'>
                    <?= csrf_field() ?>

                    <div class='row'>
                        <!-- Kolom kiri -->
                        <div class='col-md-6'>
                            <div class='mb-3'>
                                <label class='form-label fw-bold'>Kode Buku <span
                                        class='text-danger'>*</span></label>
                                <input type='text' name='kode_buku' class='form-control'
                                    value='<?= esc(old(
                                                'kode_buku',
                                                $buku['kode_buku'] ?? ''
                                            )) ?>'
                                    placeholder='Contoh: BK007' required
                                    <?= $isEdit ? 'readonly' : '' ?>>
                                <?php if ($isEdit): ?>
                                    <small class='text-muted'>Kode buku tidak dapat diubah.</small>
                                <?php endif; ?>
                            </div>
                            <div class='mb-3'>
                                <label class='form-label fw-bold'>Judul <span
                                        class='text-danger'>*</span></label>
                                <input type='text' name='judul' class='form-control'
                                    value='<?= esc(old('judul', $buku['judul'] ??
                                                '')) ?>' required>
                            </div>
                            <div class='mb-3'>
                                <label class='form-label fw-bold'>Penulis <span
                                        class='text-danger'>*</span></label>
                                <input type='text' name='penulis' class='form-control'
                                    value='<?= esc(old(
                                                'penulis',
                                                $buku['penulis'] ?? ''
                                            )) ?>' required>
                            </div>
                            <div class='mb-3'>
                                <label class='form-label fw-bold'>Penerbit</label>
                                <input type='text' name='penerbit' class='form-control'
                                    value='<?= esc(old(
                                                'penerbit',
                                                $buku['penerbit'] ?? ''
                                            )) ?>'>
                            </div>
                        </div>

                        <!-- Kolom kanan -->
                        <div class='col-md-6'>
                            <div class='mb-3'>
                                <label class='form-label fw-bold'>Tahun
                                    Terbit</label>
                                <input type='number' name='tahun' class='form-control'
                                    value='<?= esc(old('tahun', $buku['tahun'] ??
                                                '')) ?>'
                                    min='1900' max='<?= date('Y') + 1 ?>'>
                            </div>
                            <div class='mb-3'>
                                <label class='form-label fw-bold'>ISBN</label>
                                <input type='text' name='isbn' class='form-control'
                                    value='<?= esc(old('isbn', $buku['isbn'] ??
                                                '')) ?>'>
                            </div>
                            <div class='mb-3'>
                                <label class='form-label fw-bold'>Stok <span
                                        class='text-danger'>*</span></label>
                                <input type='number' name='stok' class='form-control'
                                    value='<?= esc(old('stok', $buku['stok'] ??
                                                0)) ?>'
                                    min='0' required>
                            </div>
                            <div class='mb-3'>
                                <label class='form-label fw-bold'>Kategori</label>
                                <select name='kategori_id' class='form-select'>
                                    <?php foreach ($kategori as $kid => $knama): ?>
                                        <option value='<?= esc($kid) ?>'
                                            <?= old(
                                                'kategori_id',
                                                $buku['kategori_id'] ?? ''
                                            ) == $kid ? 'selected' : '' ?>>
                                            <?= esc($knama) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class='mb-3'>
                        <label class='form-label fw-bold'>Deskripsi</label>
                        <textarea name='deskripsi' rows='4' class='form-control'><?= esc(old('deskripsi', $buku['deskripsi'] ?? '')) ?></textarea>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class='d-flex gap-2'>
                        <button type='submit' class='btn btn-primary'>
                            <i class='bi bi-save'></i> <?= $isEdit ? 'Perbarui' :
                                                            'Simpan' ?>
                        </button>
                        <a href='<?= base_url('buku') ?>' class='btn btn-secondary'>
                            <i class='bi bi-x-circle'></i> Batal
                        </a>
                        <?php if ($isEdit): ?>
                            <a href='<?= base_url('buku/hapus/' . $buku['id']) ?>'
                                class='btn btn-danger ms-auto'
                                onclick="return confirm('Yakin ingin menghapus buku ini?')">
                                <i class='bi bi-trash'></i> Hapus Buku
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>