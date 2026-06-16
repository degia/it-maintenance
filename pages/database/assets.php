<?php
require_once __DIR__ . '/../../db.php';
$data = $pdo->query("SELECT * FROM workstation ORDER BY id_asset DESC LIMIT 100")->fetchAll();
$total = $pdo->query("SELECT COUNT(*) FROM workstation")->fetchColumn();
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="section-title" style="border:none;margin:0;">Data Assets (Workstation)</h5>
        <p class="text-muted mb-0">Total: <?= $total ?> records</p>
    </div>
    <div>
        <a href="?page=settings_workstation" class="btn btn-outline-primary btn-sm">&#9881; Kelola Workstation</a>
        <a href="?page=settings_item" class="btn btn-outline-primary btn-sm">&#9881; Kelola Item</a>
    </div>
</div>
<div class="form-section">
    <div class="table-responsive">
    <table class="table table-bordered table-hover table-sm align-middle">
        <thead class="table-secondary">
            <tr><th>No</th><th>ID Asset</th><th>Hostname</th><th>Kategori</th><th>Brand</th><th>Tipe</th><th>SN</th><th>Status</th></tr>
        </thead>
        <tbody>
            <?php if (empty($data)): ?>
            <tr><td colspan="8" class="text-center text-muted">Belum ada data.</td></tr>
            <?php else: ?>
                <?php foreach ($data as $i => $r): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= htmlspecialchars($r['id_asset']) ?></td>
                    <td><?= htmlspecialchars($r['hostname']) ?></td>
                    <td><?= htmlspecialchars($r['category']) ?></td>
                    <td><?= htmlspecialchars($r['brand']) ?></td>
                    <td><?= htmlspecialchars($r['type']) ?></td>
                    <td><?= htmlspecialchars($r['sn']) ?></td>
                    <td><span class="badge bg-<?= $r['status'] === 'IN USE' ? 'success' : ($r['status'] === 'IN STORE' ? 'warning' : 'secondary') ?>"><?= htmlspecialchars($r['status']) ?></span></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    </div>
</div>
