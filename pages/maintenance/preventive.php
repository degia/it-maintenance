<?php
require_once __DIR__ . '/../../db.php';
$data = [];
try {
    $stmt = $pdo->query("SELECT * FROM preventive_maintenance ORDER BY schedule_date DESC");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // table may not exist
}
$total = count($data);
$selesai = count(array_filter($data, fn($d) => $d['status'] === 'Selesai'));
$menunggu = count(array_filter($data, fn($d) => $d['status'] === 'Menunggu'));
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="section-title" style="border:none;margin:0;">Maintenance Preventive</h5>
        <p class="text-muted mb-0">Jadwal perawatan rutin untuk mencegah kerusakan perangkat IT.</p>
    </div>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalAdd">+ Tambah Preventive</button>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card card-dashboard">
            <div class="card-body">
                <div class="card-icon" style="background:#e0f2fe;color:#0284c7;">&#128197;</div>
                <p class="card-number"><?= $total ?></p>
                <p class="card-label">Total Maintenance</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-dashboard">
            <div class="card-body">
                <div class="card-icon" style="background:#dcfce7;color:#16a34a;">&#10003;</div>
                <p class="card-number"><?= $selesai ?></p>
                <p class="card-label">Selesai</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-dashboard">
            <div class="card-body">
                <div class="card-icon" style="background:#fef3c7;color:#d97706;">&#9888;</div>
                <p class="card-number"><?= $menunggu ?></p>
                <p class="card-label">Menunggu</p>
            </div>
        </div>
    </div>
</div>

<div class="form-section">
    <div class="table-responsive">
    <table class="table table-bordered table-hover table-sm align-middle">
        <thead class="table-primary">
            <tr>
                <th>No</th>
                <th>Perangkat</th>
                <th>Kategori</th>
                <th>Jenis Perawatan</th>
                <th>Jadwal</th>
                <th>Teknisi</th>
                <th>Status</th>
                <th>Hasil</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($data)): ?>
            <tr><td colspan="8" class="text-center text-muted">Belum ada data. Klik "Tambah Preventive" untuk menambahkan.</td></tr>
            <?php else: ?>
                <?php foreach ($data as $i => $d): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= htmlspecialchars($d['device_name']) ?></td>
                    <td><?= htmlspecialchars($d['device_category']) ?></td>
                    <td><?= htmlspecialchars($d['maintenance_type']) ?></td>
                    <td><?= date('d M Y', strtotime($d['schedule_date'])) ?></td>
                    <td><?= htmlspecialchars($d['technician']) ?></td>
                    <td>
                        <?php if ($d['status'] === 'Selesai'): ?>
                            <span class="badge bg-success">Selesai</span>
                        <?php elseif ($d['status'] === 'Menunggu'): ?>
                            <span class="badge bg-warning">Menunggu</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Dibatalkan</span>
                        <?php endif; ?>
                    </td>
                    <td><small><?= htmlspecialchars($d['result'] ?: '-') ?></small></td>
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
                <h5 class="modal-title">Tambah Preventive Maintenance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="process_maintenance.php" method="POST">
                <input type="hidden" name="type" value="preventive">
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
                        <div class="col-md-6">
                            <label class="form-label">Jenis Perawatan <span class="text-danger">*</span></label>
                            <input type="text" name="maintenance_type" class="form-control" placeholder="Pembersihan Internal, Update OS, dll" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Jadwal <span class="text-danger">*</span></label>
                            <input type="date" name="schedule_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Teknisi <span class="text-danger">*</span></label>
                            <input type="text" name="technician" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option>Menunggu</option>
                                <option>Selesai</option>
                                <option>Dibatalkan</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Hasil</label>
                            <textarea name="result" class="form-control" rows="2"></textarea>
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
