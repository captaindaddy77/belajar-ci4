<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class='d-flex justify-content-between align-items-center mb-4'>
    <div>
        <h2><i class='bi bi-journals'></i> Daftar Buku</h2>
        <p class='text-muted mb-0'>Total: <?= $total ?> buku ditemukan</p>
    </div>
    <div class='d-flex gap-2'>
        <a href='<?= base_url('buku/statistik') ?>' class='btn btn-info text-white'>
            <i class='bi bi-bar-chart-line'></i> Statistik
        </a>
        <a href='<?= base_url('buku/ekspor') ?>' class='btn btn-success'>
            <i class='bi bi-file-earmark-spreadsheet'></i> Ekspor CSV
        </a>
        <a href='<?= base_url('buku/tambah') ?>' class='btn btn-primary'>
            <i class='bi bi-plus-circle'></i> Tambah Buku
        </a>
    </div>
</div>

<!-- Form Pencarian -->
<form method='GET' action='<?= base_url('buku') ?>' class='mb-4'>
    <div class='input-group'>
        <input type='text' name='q' class='form-control'
            placeholder='Cari judul, penulis, atau penerbit...'
            value='<?= esc($keyword) ?>'>
        <button class='btn btn-outline-secondary' type='submit'>
            <i class='bi bi-search'></i> Cari
        </button>
        <?php if ($keyword): ?>
            <a href='<?= base_url('buku') ?>' class='btn btn-outline-danger'>
                <i class='bi bi-x'></i> Reset
            </a>
        <?php endif; ?>
    </div>
</form>

<!-- Tabel Buku -->
<?php if (empty($buku)): ?>
    <div class='text-center py-5'>
        <i class='bi bi-inbox display-1 text-muted'></i>
        <h4 class='mt-3 text-muted'>Tidak ada buku ditemukan</h4>
        <?php if ($keyword): ?>
            <p>Coba kata kunci lain atau <a href='<?= base_url('buku') ?>'>lihat semua buku</a>.</p>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class='table-responsive'>
        <table class='table table-hover table-bordered align-middle'>
            <thead class='table-primary'>
                <tr>
                    <th width='60'>No.</th>
                    <th width='100'>Kode</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th width='120'>Kategori</th>
                    <th width='80'>Stok</th>
                    <th width='130'>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($buku as $i => $b): ?>
                    <tr>
                        <td class='text-center'><?= ($pager->getCurrentPage() - 1) * 10 + $i + 1 ?></td>
                        <td><code><?= esc($b['kode_buku']) ?></code></td>
                        <td>
                            <strong><?= esc($b['judul']) ?></strong><br>
                            <small class='text-muted'><?= esc($b['penerbit'] ?? '-') ?>,
                                <?= esc($b['tahun'] ?? '-') ?></small>
                        </td>
                        <td><?= esc($b['penulis']) ?></td>
                        <td>
                            <?php if ($b['nama_kategori']): ?>
                                <span class='badge bg-info'><?= esc($b['nama_kategori']) ?></span>
                            <?php else: ?>
                                <span class='text-muted'>-</span>
                            <?php endif; ?>
                        </td>
                        <td class='text-center'>
                            <span class='badge bg-<?= $b['stok'] > 5 ? 'success' : ($b['stok'] > 0 ? 'warning' : 'danger') ?>'>
                                <?= $b['stok'] ?>
                            </span>
                        </td>
                        <td class='text-center'>
                            <a href='<?= base_url('buku/detail/' . $b['id']) ?>' class='btn btn-sm btn-info' title='Detail'>
                                <i class='bi bi-eye'></i>
                            </a>
                            <a href='<?= base_url('buku/edit/' . $b['id']) ?>' class='btn btn-sm btn-warning' title='Edit'>
                                <i class='bi bi-pencil'></i>
                            </a>
                            <a href='<?= base_url('buku/hapus/' . $b['id']) ?>'
                                class='btn btn-sm btn-danger'
                                title='Hapus'
                                onclick="return confirm('Yakin ingin menghapus buku \" <?= esc($b['judul'], 'js') ?>\"?')">
                                <i class='bi bi-trash'></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Paginasi -->
    <div class='d-flex justify-content-center mt-3'>
        <?= $pager->links() ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>