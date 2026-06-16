<div class="welcome-section">
    <h2>Selamat Datang, <?= htmlspecialchars(get_full_name()) ?></h2>
    <p>Sistem manajemen pemeliharaan perangkat IT untuk monitoring, pelaporan, dan pengelolaan aset.</p>
</div>

<div class="row g-4">
    <div class="col-md-3">
        <div class="card card-dashboard">
            <div class="card-body">
                <div class="card-icon" style="background:#e0f2fe;color:#0284c7;">&#128187;</div>
                <p class="card-number">12</p>
                <p class="card-label">Total Perangkat</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-dashboard">
            <div class="card-body">
                <div class="card-icon" style="background:#dcfce7;color:#16a34a;">&#10003;</div>
                <p class="card-number">8</p>
                <p class="card-label">Perangkat Baik</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-dashboard">
            <div class="card-body">
                <div class="card-icon" style="background:#fef3c7;color:#d97706;">&#9888;</div>
                <p class="card-number">3</p>
                <p class="card-label">Perlu Perhatian</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-dashboard">
            <div class="card-body">
                <div class="card-icon" style="background:#fee2e2;color:#dc2626;">&#9888;</div>
                <p class="card-number">1</p>
                <p class="card-label">Rusak</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="form-section">
            <h5 class="section-title">Aktivitas Terbaru</h5>
            <table class="table table-sm table-hover">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Perangkat</th>
                        <th>Tindakan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>15 Jun 2026</td>
                        <td>M01-ENG-NB005</td>
                        <td>Exit Clearance</td>
                        <td><span class="badge bg-success">Selesai</span></td>
                    </tr>
                    <tr>
                        <td>14 Jun 2026</td>
                        <td>M02-FIN-NB003</td>
                        <td>Install OS</td>
                        <td><span class="badge bg-warning">Proses</span></td>
                    </tr>
                    <tr>
                        <td>13 Jun 2026</td>
                        <td>M03-HRD-DT001</td>
                        <td>Ganti RAM</td>
                        <td><span class="badge bg-success">Selesai</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-section">
            <h5 class="section-title">Statistik Maintenance</h5>
            <div class="mb-2 d-flex justify-content-between">
                <span>Preventive</span>
                <span class="fw-bold">45%</span>
            </div>
            <div class="progress mb-3" style="height:8px;">
                <div class="progress-bar bg-primary" style="width:45%"></div>
            </div>
            <div class="mb-2 d-flex justify-content-between">
                <span>Corrective</span>
                <span class="fw-bold">30%</span>
            </div>
            <div class="progress mb-3" style="height:8px;">
                <div class="progress-bar bg-warning" style="width:30%"></div>
            </div>
            <div class="mb-2 d-flex justify-content-between">
                <span>Predictive</span>
                <span class="fw-bold">25%</span>
            </div>
            <div class="progress mb-3" style="height:8px;">
                <div class="progress-bar bg-info" style="width:25%"></div>
            </div>
        </div>
    </div>
</div>
