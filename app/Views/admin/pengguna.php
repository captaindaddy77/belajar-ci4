<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
        <h4 class="mb-0"><i class="bi bi-people-fill"></i> Manajemen Pengguna</h4>
        <span class="badge bg-light text-primary fw-bold px-3 py-2 fs-6 rounded-pill">Total: <?= count($users) ?> Pengguna</span>
    </div>
    <div class="card-body p-4">

        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th class="py-3">Pengguna</th>
                        <th class="py-3">Email</th>
                        <th class="py-3" style="width: 220px;">Role</th>
                        <th class="py-3 text-center" style="width: 150px;">Status</th>
                        <th class="py-3">Aktivitas Terakhir</th>
                        <th class="py-3 text-center" style="width: 150px;">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $currentUserId = (int) session()->get('user_id');
                    foreach ($users as $u): 
                        $isSelf = ((int)$u['id'] === $currentUserId);
                    ?>
                    <tr>
                        <td class="py-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold me-3" style="width: 40px; height: 40px; min-width: 40px;">
                                    <?= strtoupper(substr($u['nama_lengkap'], 0, 1)) ?>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-semibold">
                                        <?= esc($u['nama_lengkap']) ?>
                                        <?php if ($isSelf): ?>
                                            <span class="badge bg-success-subtle text-success ms-1 rounded-pill small" style="font-size: 0.75rem;">Anda</span>
                                        <?php endif; ?>
                                    </h6>
                                    <small class="text-muted">@<?= esc($u['username']) ?></small>
                                </div>
                            </div>
                        </td>
                        <td><?= esc($u['email']) ?></td>
                        <td>
                            <?php if ($isSelf): ?>
                                <span class="badge bg-primary px-3 py-2 rounded-pill"><i class="bi bi-shield-fill-check"></i> Administrator</span>
                            <?php else: ?>
                                <form action="<?= base_url('admin/pengguna/ubah-role/' . $u['id']) ?>" method="post" class="d-flex align-items-center gap-1">
                                    <?= csrf_field() ?>
                                    <select name="role" class="form-select form-select-sm border-secondary-subtle" onchange="if(confirm('Apakah Anda yakin ingin mengubah role pengguna @<?= esc($u['username']) ?> menjadi ' + this.value + '?')) { this.form.submit(); } else { window.location.reload(); }">
                                        <option value="admin" <?= $u['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                        <option value="petugas" <?= $u['role'] === 'petugas' ? 'selected' : '' ?>>Petugas</option>
                                        <option value="anggota" <?= $u['role'] === 'anggota' ? 'selected' : '' ?>>Anggota</option>
                                    </select>
                                </form>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php if ($u['aktif'] == 1): ?>
                                <span class="badge bg-success px-3 py-2 rounded-pill"><i class="bi bi-check-circle-fill"></i> Aktif</span>
                            <?php else: ?>
                                <span class="badge bg-danger px-3 py-2 rounded-pill"><i class="bi bi-x-circle-fill"></i> Nonaktif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="small">
                                <div class="text-secondary"><i class="bi bi-box-arrow-in-right"></i> Login: <?= $u['last_login'] ? format_tanggal($u['last_login']) : '<span class="text-muted">-</span>' ?></div>
                                <div class="text-muted"><i class="bi bi-clock-history"></i> Daftar: <?= format_tanggal($u['created_at']) ?></div>
                            </div>
                        </td>
                        <td class="text-center">
                            <?php if ($isSelf): ?>
                                <button class="btn btn-outline-secondary btn-sm" disabled title="Anda tidak bisa menonaktifkan akun sendiri">
                                    <i class="bi bi-lock-fill"></i> Terkunci
                                </button>
                            <?php else: ?>
                                <form action="<?= base_url('admin/pengguna/toggle-aktif/' . $u['id']) ?>" method="post" onsubmit="return confirm('Apakah Anda yakin ingin <?= $u['aktif'] == 1 ? 'menonaktifkan' : 'mengaktifkan' ?> pengguna @<?= esc($u['username']) ?>?')">
                                    <?= csrf_field() ?>
                                    <?php if ($u['aktif'] == 1): ?>
                                        <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                            <i class="bi bi-person-x-fill"></i> Nonaktifkan
                                        </button>
                                    <?php else: ?>
                                        <button type="submit" class="btn btn-outline-success btn-sm w-100">
                                            <i class="bi bi-person-check-fill"></i> Aktifkan
                                        </button>
                                    <?php endif; ?>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<?= $this->endSection() ?>
