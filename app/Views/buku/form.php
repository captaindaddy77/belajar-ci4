<?= $this->extend('layout/main') ?> 
<?= $this->section('content') ?> 
  
<?php 
    $isEdit = !is_null($buku); 
    // Ambil errors dari session flashdata 
    $errors = session()->getFlashdata('errors') ?? []; 
?> 
  
<div class='row justify-content-center'> 
    <div class='col-md-9'> 
        <div class='card shadow-sm'> 
            <div class='card-header bg-primary text-white'> 
                <h4 class='mb-0'><?= esc($title) ?></h4> 
            </div> 
            <div class='card-body p-4'> 
  
                <!-- Blok Error Validasi --> 
                <?php if (!empty($errors)): ?> 
                <div class='alert alert-danger'> 
                    <h6 class='alert-heading'> 
                        <i class='bi bi-exclamation-triangle-fill'></i> 
                        Terdapat <?= count($errors) ?> kesalahan: 
                    </h6> 
                    <ul class='mb-0 ps-3'> 
                    <?php foreach ($errors as $field => $msg): ?> 
                        <li><?= esc($msg) ?></li> 
                    <?php endforeach; ?> 
                    </ul> 
                </div> 
                <?php endif; ?> 
  
                <form action='<?= base_url($isEdit ? 'buku/update/'.$buku['id'] : 'buku/simpan') ?>' 
                      method='post' novalidate> 
                    <?= csrf_field() ?> 
  
                    <div class='row'> 
                        <div class='col-md-6'> 
                            <!-- Kode Buku --> 
                            <div class='mb-3'> 
                                <label class='form-label fw-bold'> 
                                    Kode Buku <span class='text-danger'>*</span> 
                                </label> 
                                <input type='text' name='kode_buku' 
                                    class='form-control <?= isset($errors['kode_buku']) ? 'is-invalid' : '' ?>' 
                                    value='<?= esc(old('kode_buku', $buku['kode_buku'] ?? '')) ?>' 
                                    placeholder='Contoh: BK007' 
                                    <?= $isEdit ? 'readonly' : 'required' ?>> 
                                <?php if (isset($errors['kode_buku'])): ?> 
                                    <div class='invalid-feedback'><?= esc($errors['kode_buku']) ?></div> 
                                <?php endif; ?> 
                            </div> 
  
                            <!-- Judul --> 
                            <div class='mb-3'> 
                                <label class='form-label fw-bold'> 
                                    Judul <span class='text-danger'>*</span> 
                                </label> 
                                <input type='text' name='judul' 
                                    class='form-control <?= isset($errors['judul']) ? 'is-invalid' : '' ?>' 
                                    value='<?= esc(old('judul', $buku['judul'] ?? '')) ?>' required> 
                                <?php if (isset($errors['judul'])): ?> 
                                    <div class='invalid-feedback'><?= esc($errors['judul']) ?></div> 
                                <?php endif; ?> 
                            </div> 
  
                            <!-- Penulis --> 
                            <div class='mb-3'> 
                                <label class='form-label fw-bold'> 
                                    Penulis <span class='text-danger'>*</span> 
                                </label> 
                                <input type='text' name='penulis' 
                                    class='form-control <?= isset($errors['penulis']) ? 'is-invalid' : '' ?>' 
                                    value='<?= esc(old('penulis', $buku['penulis'] ?? '')) ?>' required> 
                                <?php if (isset($errors['penulis'])): ?> 
                                    <div class='invalid-feedback'><?= esc($errors['penulis']) ?></div> 
                                <?php endif; ?> 
                            </div> 
  
                            <!-- Penerbit --> 
                            <div class='mb-3'> 
                                <label class='form-label fw-bold'>Penerbit</label> 
                                <input type='text' name='penerbit' class='form-control' 
                                    value='<?= esc(old('penerbit', $buku['penerbit'] ?? '')) ?>'> 
                            </div> 
                        </div> 
  
                        <div class='col-md-6'> 
                            <!-- Tahun --> 
                            <div class='mb-3'> 
                                <label class='form-label fw-bold'>Tahun Terbit</label> 
                                <input type='number' name='tahun' 
                                    class='form-control <?= isset($errors['tahun']) ? 'is-invalid' : '' ?>' 
                                    value='<?= esc(old('tahun', $buku['tahun'] ?? '')) ?>' 
                                    min='1500' max='<?= date('Y') + 1 ?>'> 
                                <?php if (isset($errors['tahun'])): ?> 
                                    <div class='invalid-feedback'><?= esc($errors['tahun']) ?></div> 
                                <?php endif; ?> 
                            </div> 
  
                            <!-- ISBN --> 
                            <div class='mb-3'> 
                                <label class='form-label fw-bold'>ISBN</label> 
                                <input type='text' name='isbn' 
                                    class='form-control <?= isset($errors['isbn']) ? 'is-invalid' : '' ?>' 
                                    value='<?= esc(old('isbn', $buku['isbn'] ?? '')) ?>' 
                                    placeholder='978-XXXXXXXXXX'> 
                                <?php if (isset($errors['isbn'])): ?> 
                                    <div class='invalid-feedback'><?= esc($errors['isbn']) ?></div> 
                                <?php endif; ?> 
                            </div> 
  
                            <!-- Stok --> 
                            <div class='mb-3'> 
                                <label class='form-label fw-bold'> 
                                    Stok <span class='text-danger'>*</span> 
                                </label> 
                                <input type='number' name='stok' 
                                    class='form-control <?= isset($errors['stok']) ? 'is-invalid' : '' ?>' 
                                    value='<?= esc(old('stok', $buku['stok'] ?? 0)) ?>' 
                                    min='0' required> 
                                <?php if (isset($errors['stok'])): ?> 
                                    <div class='invalid-feedback'><?= esc($errors['stok']) ?></div> 
                                <?php endif; ?> 
                            </div> 
  
                            <!-- Kategori --> 
                            <div class='mb-3'> 
                                <label class='form-label fw-bold'>Kategori</label> 
                                <select name='kategori_id' class='form-select'> 
                                    <?php foreach ($kategori as $kid => $knama): ?> 
                                    <option value='<?= esc($kid) ?>' 
                                        <?= old('kategori_id', $buku['kategori_id'] ?? '') == $kid ? 'selected' : '' ?>> 
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
                        <textarea name='deskripsi' rows='4' class='form-control' 
                            placeholder='Ringkasan isi buku (opsional)'><?= esc(old('deskripsi', $buku['deskripsi'] ?? '')) ?></textarea> 
                    </div> 
  
                    <!-- Tombol Aksi --> 
                    <div class='d-flex flex-wrap gap-2'> 
                        <button type='submit' class='btn btn-primary'> 
                            <i class='bi bi-save'></i> <?= $isEdit ? 'Perbarui Data' : 'Simpan Buku' ?> 
                        </button> 
                        <a href='<?= base_url('buku') ?>' class='btn btn-secondary'> 
                            <i class='bi bi-x-circle'></i> Batal 
                        </a> 
                        <?php if ($isEdit): ?> 
                        <a href='<?= base_url('buku/hapus/'.$buku['id']) ?>' 
                           class='btn btn-danger ms-auto' 
                           onclick="return confirm('Yakin menghapus buku ini secara permanen?')"> 
                            <i class='bi bi-trash'></i> Hapus Buku Ini 
                        </a> 
                        <?php endif; ?> 
                    </div> 
                </form> 
            </div> 
        </div> 
    </div> 
</div> 
  
<?= $this->endSection() ?>