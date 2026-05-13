<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<!-- Hero Section -->
<div class='bg-primary text-white rounded-3 p-5 mb-4'>
    <h1 class='display-5 fw-bold'>
        <i class='bi bi-book-half'></i> <?= esc($sapaan) ?>!
    </h1>
    <p class='fs-5'>Selamat datang di Sistem Perpustakaan Digital.</p>
</div>

<!-- Statistik Cards -->
<h4 class='mb-3'>Statistik Perpustakaan</h4>
<div class='row g-3 mb-5'>
    <div class='col-md-3'>
        <div class='card text-center h-100 border-primary'>
            <div class='card-body'>
                <i class='bi bi-journals fs-2 text-primary'></i>
                <h2 class='my-2'><?= $statistik['total_buku'] ?></h2>
                <p class='text-muted mb-0'>Total Buku</p>
            </div>
        </div>
    </div>
    <div class='col-md-3'>
        <div class='card text-center h-100 border-success'>
            <div class='card-body'>
                <i class='bi bi-people fs-2 text-success'></i>
                <h2 class='my-2'><?= $statistik['total_anggota'] ?></h2>
                <p class='text-muted mb-0'>Total Anggota</p>
            </div>
        </div>
    </div>
    <div class='col-md-3'>
        <div class='card text-center h-100 border-warning'>
            <div class='card-body'>
                <i class='bi bi-bookmark-check fs-2 text-warning'></i>
                <h2 class='my-2'><?= $statistik['buku_dipinjam'] ?></h2>
                <p class='text-muted mb-0'>Sedang Dipinjam</p>
            </div>
        </div>
    </div>

    <div class='col-md-3'>
        <div class='card text-center h-100 border-info'>
            <div class='card-body'>
                <i class='bi bi-check-circle fs-2 text-info'></i>
                <h2 class='my-2'><?= $statistik['buku_tersedia'] ?></h2>
                <p class='text-muted mb-0'>Tersedia</p>
            </div>
        </div>
    </div>
</div>

<!-- Buku Terbaru -->
<h4 class='mb-3'>Buku Terbaru Masuk</h4>
<div class='row g-3'>
    <?php foreach ($buku_terbaru as $buku): ?>
        <div class='col-md-4'>
            <div class='card h-100'>
                <div class='card-body'>
                    <h5 class='card-title'><?= esc($buku['judul']) ?></h5>
                    <p class='card-text text-muted'>
                        <i class='bi bi-person'></i> <?= esc($buku['penulis']) ?><br>
                        <i class='bi bi-calendar'></i> <?= esc($buku['tahun']) ?>
                    </p>
                </div>
                <div class='card-footer bg-transparent'>
                    <a href='<?= base_url('buku') ?>' class='btn btn-sm btn-outlineprimary'>
                        Detail <i class='bi bi-arrow-right'></i>
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?= $this->endSection() ?>