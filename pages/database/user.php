<?php
require_once __DIR__ . '/../../db.php';
$data = $pdo->query("SELECT * FROM employee ORDER BY nip DESC LIMIT 100")->fetchAll();
$total = $pdo->query("SELECT COUNT(*) FROM employee")->fetchColumn();
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="section-title" style="border:none;margin:0;">Data User (Employee)</h5>
        <p class="text-muted mb-0">Total: <?= $total ?> records</p>
    </div>
    <div>
        <a href="?page=settings_employee" class="btn btn-outline-primary btn-sm">&#9881; Kelola Employee</a>
        <a href="?page=settings_email" class="btn btn-outline-primary btn-sm">&#9881; Kelola Email</a>
    </div>
</div>
<div class="form-section">
    <div class="table-responsive">
    <table class="table table-bordered table-hover table-sm align-middle">
        <thead class="table-secondary">
            <tr><th>No</th><th>NIP</th><th>Nama</th><th>Level</th><th>Unit</th><th>Status</th><th>Email</th></tr>
        </thead>
        <tbody>
            <?php if (empty($data)): ?>
            <tr><td colspan="7" class="text-center text-muted">Belum ada data.</td></tr>
            <?php else: ?>
                <?php foreach ($data as $i => $r): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= htmlspecialchars($r['nip']) ?></td>
                    <td><?= htmlspecialchars($r['name']) ?></td>
                    <td><?= htmlspecialchars($r['id_level']) ?></td>
                    <td><?= htmlspecialchars($r['site_unit'] . ' / ' . $r['business_unit']) ?></td>
                    <td><span class="badge bg-<?= $r['status'] === 'ACTIVE' ? 'success' : 'secondary' ?>"><?= htmlspecialchars($r['status']) ?></span></td>
                    <td><?= htmlspecialchars($r['email']) ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    </div>
</div>
