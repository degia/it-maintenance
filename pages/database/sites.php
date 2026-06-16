<?php
require_once __DIR__ . '/../../db.php';
$data = $pdo->query("SELECT * FROM site ORDER BY id_site ASC")->fetchAll();
$total = $pdo->query("SELECT COUNT(*) FROM site")->fetchColumn();
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="section-title" style="border:none;margin:0;">Data Sites</h5>
        <p class="text-muted mb-0">Total: <?= $total ?> records</p>
    </div>
    <div>
        <a href="?page=settings_site" class="btn btn-outline-primary btn-sm">&#9881; Kelola Site</a>
    </div>
</div>
<div class="form-section">
    <div class="table-responsive">
    <table class="table table-bordered table-hover table-sm align-middle">
        <thead class="table-secondary">
            <tr><th>No</th><th>Kode</th><th>Nama Site</th><th>Business Unit</th><th>Kota</th><th>Provinsi</th><th>Alamat</th></tr>
        </thead>
        <tbody>
            <?php if (empty($data)): ?>
            <tr><td colspan="7" class="text-center text-muted">Belum ada data.</td></tr>
            <?php else: ?>
                <?php foreach ($data as $i => $r): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= htmlspecialchars($r['id_site']) ?></td>
                    <td><?= htmlspecialchars($r['site']) ?></td>
                    <td><?= htmlspecialchars($r['business_unit']) ?></td>
                    <td><?= htmlspecialchars($r['city']) ?></td>
                    <td><?= htmlspecialchars($r['provincy']) ?></td>
                    <td><?= htmlspecialchars(mb_substr($r['address'] ?? '', 0, 60)) ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    </div>
</div>
