<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class='d-flex justify-content-between align-items-center mb-4'>
    <div>
        <h2><i class='bi bi-bar-chart-line'></i> Statistik Buku</h2>
        <p class='text-muted mb-0'>Ringkasan data koleksi perpustakaan</p>
    </div>
    <a href='<?= base_url('buku') ?>' class='btn btn-secondary'>
        <i class='bi bi-arrow-left'></i> Kembali ke Daftar Buku
    </a>
</div>

<!-- Kartu Ringkasan -->
<div class='row g-4 mb-4'>
    <div class='col-md-4'>
        <div class='card text-white bg-primary shadow-sm h-100'>
            <div class='card-body d-flex align-items-center gap-3'>
                <i class='bi bi-journals display-4'></i>
                <div>
                    <div class='fs-1 fw-bold'><?= esc($stat['total']) ?></div>
                    <div class='fs-6'>Total Judul Buku</div>
                </div>
            </div>
        </div>
    </div>
    <div class='col-md-4'>
        <div class='card text-white bg-success shadow-sm h-100'>
            <div class='card-body d-flex align-items-center gap-3'>
                <i class='bi bi-stack display-4'></i>
                <div>
                    <div class='fs-1 fw-bold'><?= esc($stat['total_stok']) ?></div>
                    <div class='fs-6'>Total Stok Keseluruhan</div>
                </div>
            </div>
        </div>
    </div>
    <div class='col-md-4'>
        <div class='card text-white bg-info shadow-sm h-100'>
            <div class='card-body d-flex align-items-center gap-3'>
                <i class='bi bi-calculator display-4'></i>
                <div>
                    <div class='fs-1 fw-bold'><?= esc($stat['rata_rata']) ?></div>
                    <div class='fs-6'>Rata-rata Stok per Buku</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class='row g-4'>
    <!-- Tabel distribusi per kategori -->
    <div class='col-md-6'>
        <div class='card shadow-sm h-100'>
            <div class='card-header bg-primary text-white'>
                <h5 class='mb-0'><i class='bi bi-tags'></i> Distribusi per Kategori</h5>
            </div>
            <div class='card-body p-0'>
                <?php if (empty($stat['per_kategori'])): ?>
                    <p class='text-muted p-3'>Tidak ada data.</p>
                <?php else: ?>
                    <table class='table table-hover table-bordered mb-0 align-middle'>
                        <thead class='table-light'>
                            <tr>
                                <th>Kategori</th>
                                <th class='text-center'>Jml Buku</th>
                                <th class='text-center'>Jml Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($stat['per_kategori'] as $k): ?>
                                <tr>
                                    <td><?= esc($k['nama_kategori']) ?></td>
                                    <td class='text-center'><span class='badge bg-primary'><?= esc($k['jumlah_buku']) ?></span></td>
                                    <td class='text-center'><span class='badge bg-success'><?= esc($k['jumlah_stok']) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- 5 Buku stok terbanyak -->
    <div class='col-md-6'>
        <div class='card shadow-sm h-100'>
            <div class='card-header bg-success text-white'>
                <h5 class='mb-0'><i class='bi bi-trophy'></i> Top 5 Stok Terbanyak</h5>
            </div>
            <div class='card-body p-0'>
                <?php if (empty($stat['stok_terbanyak'])): ?>
                    <p class='text-muted p-3'>Tidak ada data.</p>
                <?php else: ?>
                    <table class='table table-hover table-bordered mb-0 align-middle'>
                        <thead class='table-light'>
                            <tr>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th class='text-center'>Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($stat['stok_terbanyak'] as $b): ?>
                                <tr>
                                    <td>
                                        <strong><?= esc($b['judul']) ?></strong><br>
                                        <small class='text-muted'><code><?= esc($b['kode_buku']) ?></code></small>
                                    </td>
                                    <td><?= esc($b['nama_kategori']) ?></td>
                                    <td class='text-center'><span class='badge bg-success fs-6'><?= esc($b['stok']) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Buku perlu restock -->
    <div class='col-12'>
        <div class='card shadow-sm border-danger'>
            <div class='card-header bg-danger text-white'>
                <h5 class='mb-0'>
                    <i class='bi bi-exclamation-triangle-fill'></i> Buku Perlu Restock
                    <?php if (!empty($stat['perlu_restock'])): ?>
                        <span class='badge bg-white text-danger ms-2'><?= count($stat['perlu_restock']) ?></span>
                    <?php endif; ?>
                </h5>
            </div>
            <div class='card-body p-0'>
                <?php if (empty($stat['perlu_restock'])): ?>
                    <div class='text-center py-4'>
                        <i class='bi bi-check-circle-fill text-success display-4'></i>
                        <p class='mt-2 text-muted'>Semua buku memiliki stok tersedia.</p>
                    </div>
                <?php else: ?>
                    <div class='table-responsive'>
                        <table class='table table-hover table-bordered mb-0 align-middle'>
                            <thead class='table-light'>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th class='text-center'>Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($stat['perlu_restock'] as $i => $b): ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><code><?= esc($b['kode_buku']) ?></code></td>
                                        <td><?= esc($b['judul']) ?></td>
                                        <td><?= esc($b['nama_kategori']) ?></td>
                                        <td class='text-center'><span class='badge bg-danger'>0</span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>