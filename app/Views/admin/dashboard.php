<?= $this->extend('layout/main') ?> 
<?= $this->section('content') ?> 
  
<div class='d-flex justify-content-between align-items-center mb-4'> 
    <h2><i class='bi bi-speedometer2'></i> Dashboard Admin</h2> 
    <span class='text-muted'>Halo, <?= esc(session()->get('nama')) ?>!</span> 
</div> 
  
<!-- Kartu Statistik --> 
<div class='row g-3 mb-4'> 
    <div class='col-md-3'> 
        <div class='card text-white bg-primary text-center'> 
            <div class='card-body'> 
                <i class='bi bi-journals fs-2'></i> 
                <h3 class='my-1'><?= $total_buku ?></h3> 
                <div>Total Judul Buku</div> 
            </div> 
        </div> 
    </div> 
    <div class='col-md-3'> 
        <div class='card text-white bg-success text-center'> 
            <div class='card-body'> 
                <i class='bi bi-archive fs-2'></i> 
                <h3 class='my-1'><?= $total_stok ?></h3> 
                <div>Total Stok Buku</div> 
            </div> 
        </div> 
    </div> 
    <div class='col-md-3'> 
        <div class='card text-white bg-info text-center'> 
            <div class='card-body'> 
                <i class='bi bi-people fs-2'></i> 
                <h3 class='my-1'><?= $total_user ?></h3> 
                <div>Total Pengguna</div> 
            </div> 
        </div> 
    </div> 
    <div class='col-md-3'> 
        <div class='card text-white bg-danger text-center'> 
            <div class='card-body'> 
                <i class='bi bi-exclamation-triangle fs-2'></i> 
                <h3 class='my-1'><?= $buku_habis ?></h3> 
                <div>Buku Stok Habis</div> 
            </div> 
        </div> 
    </div> 
</div> 
  
<!-- Distribusi per Kategori --> 
<div class='row'> 
    <div class='col-md-6'> 
        <div class='card mb-4'> 
            <div class='card-header'><strong>Distribusi Buku per Kategori</strong></div> 
            <div class='card-body p-0'> 
                <table class='table table-hover mb-0'> 
                    <thead class='table-light'><tr><th>Kategori</th><th>Judul</th><th>Stok</th></tr></thead>
                    <tbody> 
                    <?php foreach ($per_kategori as $k): ?> 
                        <tr> 
                            <td><?= esc($k['nama'] ?? 'Tanpa Kategori') ?></td> 
                            <td><?= $k['jumlah'] ?></td> 
                            <td><?= $k['total_stok'] ?></td> 
                        </tr> 
                    <?php endforeach; ?> 
                    </tbody> 
                </table> 
            </div> 
        </div> 
    </div> 
    <div class='col-md-6'> 
        <div class='card mb-4'> 
            <div class='card-header'><strong>Pengguna Terbaru</strong></div> 
            <div class='card-body p-0'> 
                <table class='table table-hover mb-0'> 
                    <thead class='table-light'><tr><th>Nama</th><th>Role</th><th>Bergabung</th></tr></thead>
                    <tbody> 
                    <?php foreach ($user_terbaru as $u): ?> 
                        <tr> 
                            <td><?= esc($u['nama_lengkap']) ?></td> 
                            <td><span class='badge bg-secondary'><?= esc($u['role']) ?></span></td> 
                            <td><?= format_tanggal($u['created_at']) ?></td> 
                        </tr> 
                    <?php endforeach; ?> 
                    </tbody> 
                </table> 
            </div> 
        </div> 
    </div> 
</div> 
  
<?= $this->endSection() ?>
