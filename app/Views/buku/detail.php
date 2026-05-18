<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="bi bi-info-circle"></i> Detail Buku</h2>
            <p class="text-muted mb-0">Informasi lengkap mengenai koleksi buku</p>
        </div>
        <a href="<?= base_url('buku') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Informasi Publikasi</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="200">Judul Buku</th>
                            <td>: <strong><?= esc($buku['judul']) ?></strong></td>
                        </tr>
                        <tr>
                            <th>Kode Buku</th>
                            <td>: <code class="fs-6"><?= esc($buku['kode_buku']) ?></code></td>
                        </tr>
                        <tr>
                            <th>Penulis</th>
                            <td>: <?= esc($buku['penulis']) ?></td>
                        </tr>
                        <tr>
                            <th>Penerbit</th>
                            <td>: <?= esc($buku['penerbit'] ?? '-') ?></td>
                        </tr>
                        <tr>
                            <th>Tahun Terbit</th>
                            <td>: <?= esc($buku['tahun'] ?? '-') ?></td>
                        </tr>
                        <tr>
                            <th>ISBN</th>
                            <td>: <?= esc($buku['isbn'] ?? '-') ?></td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>:
                                <?php if ($buku['nama_kategori']): ?>
                                    <span class="badge bg-info"><?= esc($buku['nama_kategori']) ?></span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>

                    <hr>
                    <h5>Sinopsis / Deskripsi</h5>
                    <p class="text-justify mt-3">
                        <?= $buku['deskripsi'] ? esc($buku['deskripsi']) : '<i class="text-muted">Tidak ada deskripsi tersedia.</i>' ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="card-title mb-0">Status Koleksi</h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <label class="d-block text-muted small">Stok Tersedia</label>
                        <span class="display-4 fw-bold text-<?= $buku['stok'] > 5 ?
                                                                'success' : ($buku['stok'] > 0 ? 'warning' : 'danger') ?>"> <?= $buku['stok'] ?>
                        </span>
                        <p class="mt-2">
                            <?php if ($buku['stok'] > 5): ?>
                                <span class="badge bg-success">Tersedia</span>
                            <?php elseif ($buku['stok'] > 0): ?>
                                <span class="badge bg-warning">Stok Menipis</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Habis</span>
                            <?php endif; ?>
                        </p>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <a href="<?= base_url('buku/edit/' . $buku['id']) ?>"
                            class="btn btn-warning text-white">
                            <i class="bi bi-pencil-square"></i> Edit Data
                        </a>
                        <button type="button" class="btn btn-outline-danger"
                            onclick="if(confirm('Hapus buku ini?')) window.location.href='<?= base_url('buku/hapus/' . $buku['id']) ?>'">
                            <i class="bi bi-trash"></i> Hapus Koleksi
                        </button>
                    </div>
                </div>
                <div class="card-footer small text-muted">
                    Terakhir diperbarui: <br>
                    <?= date('d M Y, H:i', strtotime($buku['updated_at'])) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>