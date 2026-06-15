<?php
require_once __DIR__ . '/../../db.php';
$data = [];
try {
    $stmt = $pdo->query("SELECT * FROM corrective_maintenance ORDER BY report_date DESC");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {}
$total = count($data);
$selesai = count(array_filter($data, fn($d) => $d['status'] === 'Selesai'));
$proses = count(array_filter($data, fn($d) => $d['status'] === 'Proses'));
$sparepart = count(array_filter($data, fn($d) => $d['status'] === 'Menunggu Sparepart'));
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="section-title" style="border:none;margin:0;">Maintenance Corrective</h5>
        <p class="text-muted mb-0">Perbaikan perangkat IT yang mengalami kerusakan atau masalah.</p>
    </div>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalAdd">+ Tambah Corrective</button>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card card-dashboard">
            <div class="card-body">
                <div class="card-icon" style="background:#e0f2fe;color:#0284c7;">&#128203;</div>
                <p class="card-number"><?= $total ?></p>
                <p class="card-label">Total Laporan</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-dashboard">
            <div class="card-body">
                <div class="card-icon" style="background:#fee2e2;color:#dc2626;">&#9888;</div>
                <p class="card-number"><?= $proses ?></p>
                <p class="card-label">Dalam Perbaikan</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-dashboard">
            <div class="card-body">
                <div class="card-icon" style="background:#dcfce7;color:#16a34a;">&#10003;</div>
                <p class="card-number"><?= $selesai ?></p>
                <p class="card-label">Selesai</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-dashboard">
            <div class="card-body">
                <div class="card-icon" style="background:#fef3c7;color:#d97706;">&#9888;</div>
                <p class="card-number"><?= $sparepart ?></p>
                <p class="card-label">Menunggu Sparepart</p>
            </div>
        </div>
    </div>
</div>

<div class="form-section">
    <div class="table-responsive">
    <table class="table table-bordered table-hover table-sm align-middle">
        <thead class="table-danger">
            <tr>
                <th>No</th>
                <th>Perangkat</th>
                <th>Kategori</th>
                <th>Masalah</th>
                <th>Tanggal Lapor</th>
                <th>Prioritas</th>
                <th>Teknisi</th>
                <th>Status</th>
                <th>Solusi</th>
                <th>Sparepart</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($data)): ?>
            <tr><td colspan="10" class="text-center text-muted">Belum ada data. Klik "Tambah Corrective" untuk menambahkan.</td></tr>
            <?php else: ?>
                <?php foreach ($data as $i => $d): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= htmlspecialchars($d['device_name']) ?></td>
                    <td><?= htmlspecialchars($d['device_category']) ?></td>
                    <td><small><?= htmlspecialchars(mb_substr($d['problem'], 0, 50)) ?><?= strlen($d['problem']) > 50 ? '...' : '' ?></small></td>
                    <td><?= date('d M Y', strtotime($d['report_date'])) ?></td>
                    <td>
                        <?php if ($d['priority'] === 'Tinggi'): ?>
                            <span class="badge bg-danger">Tinggi</span>
                        <?php elseif ($d['priority'] === 'Sedang'): ?>
                            <span class="badge bg-warning">Sedang</span>
                        <?php else: ?>
                            <span class="badge bg-success">Rendah</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($d['technician'] ?: '-') ?></td>
                    <td>
                        <?php if ($d['status'] === 'Selesai'): ?>
                            <span class="badge bg-success">Selesai</span>
                        <?php elseif ($d['status'] === 'Proses'): ?>
                            <span class="badge bg-warning">Proses</span>
                        <?php elseif ($d['status'] === 'Menunggu Sparepart'): ?>
                            <span class="badge bg-info">Menunggu Sparepart</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Dibatalkan</span>
                        <?php endif; ?>
                    </td>
                    <td><small><?= htmlspecialchars($d['solution'] ?: '-') ?></small></td>
                    <td><small><?= htmlspecialchars($d['sparepart_needed'] ?: '-') ?></small></td>
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
                <h5 class="modal-title">Tambah Corrective Maintenance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="process_maintenance.php" method="POST">
                <input type="hidden" name="type" value="corrective">
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
                            <label class="form-label">Masalah <span class="text-danger">*</span></label>
                            <textarea name="problem" class="form-control" rows="2" required></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tanggal Lapor <span class="text-danger">*</span></label>
                            <input type="date" name="report_date" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Prioritas</label>
                            <select name="priority" class="form-select">
                                <option>Sedang</option>
                                <option>Tinggi</option>
                                <option>Rendah</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option>Proses</option>
                                <option>Selesai</option>
                                <option>Menunggu Sparepart</option>
                                <option>Dibatalkan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Teknisi</label>
                            <input type="text" name="technician" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Sparepart Dibutuhkan</label>
                            <input type="text" name="sparepart_needed" class="form-control" placeholder="Jika ada">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Solusi</label>
                            <textarea name="solution" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" name="completion_date" class="form-control">
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
