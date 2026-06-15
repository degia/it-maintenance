<div class="form-section">
    <h5 class="section-title">Maintenance Predictive</h5>
    <p>Analisis prediktif untuk memperkirakan potensi kerusakan perangkat IT berdasarkan data historis.</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card card-dashboard">
            <div class="card-body">
                <h6 class="fw-bold">Prediksi Kerusakan Bulan Depan</h6>
                <div class="mb-2 d-flex justify-content-between">
                    <span>M01-ENG-NB005</span>
                    <span class="badge bg-warning">Medium Risk</span>
                </div>
                <div class="progress mb-3" style="height:8px;">
                    <div class="progress-bar bg-warning" style="width:60%"></div>
                </div>
                <div class="mb-2 d-flex justify-content-between">
                    <span>M04-IT-PC001</span>
                    <span class="badge bg-danger">High Risk</span>
                </div>
                <div class="progress mb-3" style="height:8px;">
                    <div class="progress-bar bg-danger" style="width:85%"></div>
                </div>
                <div class="mb-2 d-flex justify-content-between">
                    <span>M05-MKT-NB002</span>
                    <span class="badge bg-success">Low Risk</span>
                </div>
                <div class="progress mb-3" style="height:8px;">
                    <div class="progress-bar bg-success" style="width:25%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-dashboard">
            <div class="card-body">
                <h6 class="fw-bold">Rekomendasi Tindakan</h6>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-0">&#9672; Ganti battery M01-ENG-NB005 dalam 2 minggu</li>
                    <li class="list-group-item px-0">&#9672; Backup data M04-IT-PC001 segera</li>
                    <li class="list-group-item px-0">&#9672; Bersihkan cooling fan M05-MKT-NB002</li>
                    <li class="list-group-item px-0">&#9672; Cek health SSD M02-FIN-NB003</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="form-section">
    <h5 class="section-title">Riwayat Prediksi</h5>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Perangkat</th>
                <th>Prediksi</th>
                <th>Akurasi</th>
                <th>Status Aktual</th>
                <th>Tanggal Prediksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>M01-ENG-NB005</td>
                <td>Battery degradation</td>
                <td>92%</td>
                <td><span class="badge bg-warning">Terbukti</span></td>
                <td>10 Mei 2026</td>
            </tr>
            <tr>
                <td>2</td>
                <td>M04-IT-PC001</td>
                <td>RAM failure risk</td>
                <td>78%</td>
                <td><span class="badge bg-warning">Terbukti</span></td>
                <td>05 Mei 2026</td>
            </tr>
            <tr>
                <td>3</td>
                <td>M06-HRD-PR001</td>
                <td>Roller wear</td>
                <td>65%</td>
                <td><span class="badge bg-success">Tidak Terbukti</span></td>
                <td>01 Mei 2026</td>
            </tr>
        </tbody>
    </table>
</div>
