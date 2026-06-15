<?php
require_once __DIR__ . '/../../db.php';
$data = [];
try {
    $stmt = $pdo->query("SELECT * FROM predictive_maintenance ORDER BY predicted_date DESC");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {}
$total = count($data);
$terbukti = count(array_filter($data, fn($d) => $d['status'] === 'Terbukti'));
$menunggu = count(array_filter($data, fn($d) => $d['status'] === 'Menunggu'));
$avg_accuracy = $total > 0 ? round(array_sum(array_column($data, 'accuracy')) / $total, 1) : 0;
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="section-title" style="border:none;margin:0;">Maintenance Predictive</h5>
        <p class="text-muted mb-0">Analisis prediktif untuk memperkirakan potensi kerusakan perangkat IT.</p>
    </div>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalAdd">+ Tambah Predictive</button>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card card-dashboard">
            <div class="card-body">
                <div class="card-icon" style="background:#e0f2fe;color:#0284c7;">&#128200;</div>
                <p class="card-number"><?= $total ?></p>
                <p class="card-label">Total Prediksi</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-dashboard">
            <div class="card-body">
                <div class="card-icon" style="background:#dcfce7;color:#16a34a;">&#10003;</div>
                <p class="card-number"><?= $terbukti ?></p>
                <p class="card-label">Terbukti</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-dashboard">
            <div class="card-body">
                <div class="card-icon" style="background:#fef3c7;color:#d97706;">&#9888;</div>
                <p class="card-number"><?= $menunggu ?></p>
                <p class="card-label">Menunggu</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-dashboard">
            <div class="card-body">
                <div class="card-icon" style="background:#e0e7ff;color:#4338ca;">&#128202;</div>
                <p class="card-number"><?= $avg_accuracy ?>%</p>
                <p class="card-label">Rata-rata Akurasi</p>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card card-dashboard">
            <div class="card-body">
                <h6 class="fw-bold">Prediksi Perangkat Berisiko Tinggi</h6>
                <?php
                $high_risk = array_filter($data, fn($d) => $d['accuracy'] >= 85 && $d['status'] === 'Menunggu');
                if ($high_risk):
                ?>
                <table class="table table-sm mb-0">
                    <thead><tr><th>Perangkat</th><th>Prediksi</th><th>Akurasi</th></tr></thead>
                    <tbody>
                        <?php foreach ($high_risk as $d): ?>
                        <tr>
                            <td><?= htmlspecialchars($d['device_name']) ?></td>
                            <td><small><?= htmlspecialchars(mb_substr($d['prediction'], 0, 40)) ?>...</small></td>
                            <td><span class="badge bg-danger"><?= $d['accuracy'] ?>%</span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p class="text-muted mb-0">Tidak ada prediksi berisiko tinggi saat ini.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-dashboard">
            <div class="card-body">
                <h6 class="fw-bold">Rekomendasi Tindakan</h6>
                <ul class="list-group list-group-flush">
                    <?php
                    $rekomendasi = array_filter($data, fn($d) => $d['status'] === 'Menunggu' && $d['recommendation']);
                    if ($rekomendasi):
                        $i = 0;
                        foreach ($rekomendasi as $d):
                            if ($i++ >= 5) break;
                    ?>
                    <li class="list-group-item px-0">&#9672; <strong><?= htmlspecialchars($d['device_name']) ?>:</strong> <?= htmlspecialchars($d['recommendation']) ?></li>
                    <?php endforeach; else: ?>
                    <li class="list-group-item px-0 text-muted">Belum ada rekomendasi.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="form-section">
    <div class="table-responsive">
    <table class="table table-bordered table-hover table-sm align-middle">
        <thead class="table-info">
            <tr>
                <th>No</th>
                <th>Perangkat</th>
                <th>Kategori</th>
                <th>Prediksi</th>
                <th>Akurasi</th>
                <th>Tanggal Prediksi</th>
                <th>Status</th>
                <th>Kondisi Aktual</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($data)): ?>
            <tr><td colspan="8" class="text-center text-muted">Belum ada data. Klik "Tambah Predictive" untuk menambahkan.</td></tr>
            <?php else: ?>
                <?php foreach ($data as $i => $d): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= htmlspecialchars($d['device_name']) ?></td>
                    <td><?= htmlspecialchars($d['device_category']) ?></td>
                    <td><small><?= htmlspecialchars(mb_substr($d['prediction'], 0, 55)) ?><?= strlen($d['prediction']) > 55 ? '...' : '' ?></small></td>
                    <td>
                        <div class="d-flex align-items-center gap-1">
                            <span><?= $d['accuracy'] ?>%</span>
                            <div class="progress" style="width:50px;height:6px;">
                                <div class="progress-bar <?= $d['accuracy'] >= 85 ? 'bg-danger' : ($d['accuracy'] >= 70 ? 'bg-warning' : 'bg-success') ?>" style="width:<?= $d['accuracy'] ?>%"></div>
                            </div>
                        </div>
                    </td>
                    <td><?= date('d M Y', strtotime($d['predicted_date'])) ?></td>
                    <td>
                        <?php if ($d['status'] === 'Terbukti'): ?>
                            <span class="badge bg-danger">Terbukti</span>
                        <?php elseif ($d['status'] === 'Tidak Terbukti'): ?>
                            <span class="badge bg-success">Tidak Terbukti</span>
                        <?php else: ?>
                            <span class="badge bg-warning">Menunggu</span>
                        <?php endif; ?>
                    </td>
                    <td><small><?= htmlspecialchars($d['actual_condition'] ?: '-') ?></small></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    </div>
</div>

<div class="modal fade" id="modalAdd" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Predictive Maintenance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="process_maintenance.php" method="POST">
                <input type="hidden" name="type" value="predictive">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Perangkat <span class="text-danger">*</span></label>
                            <input type="text" name="device_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select name="device_category" class="form-select" required>
                                <option value="">Pilih...</option>
                                <option>Laptop</option>
                                <option>Desktop</option>
                                <option>Printer</option>
                                <option>Monitor</option>
                                <option>Network</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Prediksi <span class="text-danger">*</span></label>
                            <textarea name="prediction" class="form-control" rows="2" required></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Akurasi (%)</label>
                            <input type="number" name="accuracy" class="form-control" step="0.01" min="0" max="100" placeholder="85.00">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tanggal Prediksi <span class="text-danger">*</span></label>
                            <input type="date" name="predicted_date" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option>Menunggu</option>
                                <option>Terbukti</option>
                                <option>Tidak Terbukti</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Rekomendasi</label>
                            <textarea name="recommendation" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Kondisi Aktual</label>
                            <textarea name="actual_condition" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
