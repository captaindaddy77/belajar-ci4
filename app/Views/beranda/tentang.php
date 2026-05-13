<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class='row'>
    <div class='col-md-8'>
        <h1 class='mb-4'><i class='bi bi-info-circle'></i> Tentang Sistem</h1>

        <div class='card mb-4'>
            <div class='card-header bg-primary text-white'>
                <strong>Informasi Aplikasi</strong>
            </div>
            <div class='card-body'>
                <table class='table table-borderless mb-0'>
                    <tr>
                        <th width='200'>Nama Aplikasi</th>
                        <td>PerpustakaanKu</td>
                    </tr>

                    <tr>
                        <th>Versi</th>
                        <td><?= esc($versi) ?></td>
                    </tr>
                    <tr>
                        <th>Framework</th>
                        <td><?= esc($framework) ?></td>
                    </tr>
                    <tr>
                        <th>Dibangun Oleh</th>
                        <td>Tim Praktikum Pemrograman Web 2</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class='card'>
            <div class='card-header bg-success text-white'>
                <strong>Fitur Utama</strong>
            </div>
            <ul class='list-group list-group-flush'>
                <?php foreach ($fitur as $f): ?>
                    <li class='list-group-item'>
                        <i class='bi bi-check2-circle text-success me-2'></i>
                        <?= esc($f) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <div class='col-md-4'>
        <div class='card bg-light'>
            <div class='card-body text-center'>
                <i class='bi bi-gear-wide-connected display-1 text-primary'></i>
                <h5 class='mt-3'>Teknologi Yang Digunakan</h5>
                <ul class='list-unstyled text-start mt-3'>
                    <li><i class='bi bi-dot'></i> PHP <?= PHP_VERSION ?></li>
                    <li><i class='bi bi-dot'></i> CodeIgniter 4</li>
                    <li><i class='bi bi-dot'></i> MySQL / MariaDB</li>
                    <li><i class='bi bi-dot'></i> Bootstrap 5</li>
                    <li><i class='bi bi-dot'></i> Bootstrap Icons</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>