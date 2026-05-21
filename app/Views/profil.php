<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Mahasiswa</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Profil Mahasiswa</h4>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">NPM</th>
                            <td width="1%">:</td>
                            <td><?= esc($npm) ?></td>
                        </tr>
                        <tr>
                            <th>Nama Lengkap</th>
                            <td>:</td>
                            <td><?= esc($nama) ?></td>
                        </tr>
                        <tr>
                            <th>Program Studi</th>
                            <td>:</td>
                            <td><?= esc($prodi) ?></td>
                        </tr>
                        <tr>
                            <th>Angkatan</th>
                            <td>:</td>
                            <td><?= esc($angkatan) ?></td>
                        </tr>
                        <tr>
                            <th>IPK</th>
                            <td>:</td>
                            <td> 
                                <?php 
                                    $ipkVal = esc($ipk);
                                    if ($ipkVal >= 3.5) {
                                        $badge = 'bg-success';
                                    } elseif ($ipkVal >= 3.0) {
                                        $badge = 'bg-warning text-dark';
                                    } else {
                                        $badge = 'bg-danger';
                                    }
                                ?>
                                <span class="badge <?= $badge ?>"><?= $ipkVal ?></span>
                            </td>
                        </tr>
                        <tr>
                            <th>Mata Kuliah</th>
                            <td>:</td>
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    <?php foreach ($matkul as $mk) : ?>
                                        <span class="badge bg-secondary fw-normal"><?= esc($mk) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
