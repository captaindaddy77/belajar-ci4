<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class='d-flex justify-content-between align-items-center mb-4'>
    <div>
        <h2><i class='bi bi-tags'></i> Daftar Kategori</h2>
        <p class='text-muted mb-0'>Total: <?= count($kategori) ?> kategori ditemukan</p>
    </div>
    <a href='<?= base_url('kategori/tambah') ?>' class='btn btn-primary'>
        <i class='bi bi-plus-circle'></i> Tambah Kategori
    </a>
</div>

<!-- Tabel Kategori -->
<?php if (empty($kategori)): ?>
    <div class='text-center py-5'>
        <i class='bi bi-inbox display-1 text-muted'></i>
        <h4 class='mt-3 text-muted'>Tidak ada kategori ditemukan</h4>
        <p>Silakan tambahkan kategori baru.</p>
    </div>
<?php else: ?>
    <div class='table-responsive'>
        <table class='table table-hover table-bordered align-middle'>
            <thead class='table-primary'>
                <tr>
                    <th width='60' class='text-center'>No.</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th width='150' class='text-center'>Jumlah Buku</th>
                    <th width='130' class='text-center'>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($kategori as $i => $k): ?>
                    <tr>
                        <td class='text-center'><?= $i + 1 ?></td>
                        <td><strong><?= esc($k['nama']) ?></strong></td>
                        <td><?= esc($k['deskripsi'] ?? '-') ?></td>
                        <td class='text-center'>
                            <?php if ($k['jumlah_buku'] > 0): ?>
                                <span class='badge bg-info'><?= $k['jumlah_buku'] ?> Buku</span>
                            <?php else: ?>
                                <span class='badge bg-secondary'>0 Buku</span>
                            <?php endif; ?>
                        </td>
                        <td class='text-center'>
                            <a href='<?= base_url('kategori/edit/' . $k['id']) ?>' class='btn btn-sm btn-warning' title='Edit'>
                                <i class='bi bi-pencil'></i>
                            </a>
                            <button type='button'
                                class='btn btn-sm btn-danger btn-hapus'
                                title='Hapus'
                                data-id='<?= $k['id'] ?>'
                                data-nama='<?= esc($k['nama'], 'attr') ?>'
                                data-jumlah='<?= $k['jumlah_buku'] ?>'>
                                <i class='bi bi-trash'></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<!-- Modal Konfirmasi Hapus -->
<div class='modal fade' id='modalHapus' tabindex='-1' aria-hidden='true'>
    <div class='modal-dialog modal-dialog-centered'>
        <div class='modal-content border-0 shadow'>
            <div class='modal-header bg-danger text-white'>
                <h5 class='modal-title'>
                    <i class='bi bi-exclamation-triangle-fill me-2'></i>Konfirmasi Hapus
                </h5>
                <button type='button' class='btn-close btn-close-white' data-bs-dismiss='modal'></button>
            </div>
            <div class='modal-body py-4'>
                <div id='modalPesan'></div>
            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>
                    <i class='bi bi-x-circle'></i> Batal
                </button>
                <a id='btnKonfirmasiHapus' href='#' class='btn btn-danger'>
                    <i class='bi bi-trash'></i> Ya, Hapus!
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.btn-hapus').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const id     = this.dataset.id;
            const nama   = this.dataset.nama;
            const jumlah = parseInt(this.dataset.jumlah);

            const hapusUrl = '<?= base_url('kategori/hapus') ?>/' + id;
            document.getElementById('btnKonfirmasiHapus').href = hapusUrl;

            let pesan;
            if (jumlah > 0) {
                pesan = `<div class="alert alert-warning d-flex align-items-start gap-2 mb-0">
                            <i class="bi bi-exclamation-circle-fill fs-5 mt-1"></i>
                            <div>
                                <strong>Kategori tidak dapat dihapus!</strong><br>
                                Kategori <strong>"${nama}"</strong> masih digunakan oleh <strong>${jumlah} buku</strong>.
                                Hapus atau pindahkan buku tersebut terlebih dahulu.
                            </div>
                         </div>`;
                document.getElementById('btnKonfirmasiHapus').classList.add('d-none');
            } else {
                pesan = `<div class="d-flex align-items-start gap-3">
                            <i class="bi bi-trash-fill text-danger fs-3"></i>
                            <div>
                                Apakah Anda yakin ingin menghapus kategori<br>
                                <strong class="fs-5">"${nama}"</strong> ?<br>
                                <small class="text-muted">Tindakan ini tidak dapat dibatalkan.</small>
                            </div>
                         </div>`;
                document.getElementById('btnKonfirmasiHapus').classList.remove('d-none');
            }

            document.getElementById('modalPesan').innerHTML = pesan;

            const modal = new bootstrap.Modal(document.getElementById('modalHapus'));
            modal.show();
        });
    });
</script>

<?= $this->endSection() ?>
