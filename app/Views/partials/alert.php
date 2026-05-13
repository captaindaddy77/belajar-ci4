<?php

/** 
 * Partial view untuk menampilkan pesan alert 
 * Usage di view: <?= view('partials/alert', ['type' => 'success', 'msg' =>
'Berhasil!']) ?> 
 */
?>
<?php if (!empty($msg)): ?>
    <div class='alert alert-<?= esc($type ?? 'info') ?> alert-dismissible fade show'
        role='alert'>
        <i class='bi bi-<?= $type === 'success' ? 'check-circle' : ($type === 'danger' ?
                            'x-circle' : 'info-circle') ?>'></i>
        <?= esc($msg) ?>
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
    </div>
<?php endif; ?>