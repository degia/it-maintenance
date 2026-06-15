<div class="form-section">
    <h5 class="section-title">Report Maintenance</h5>
    <p>Laporan dan rekap kegiatan maintenance perangkat IT.</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <select class="form-select">
            <option>Bulan: Juni 2026</option>
            <option>Mei 2026</option>
            <option>April 2026</option>
        </select>
    </div>
    <div class="col-md-3">
        <select class="form-select">
            <option>Semua Tipe</option>
            <option>Preventive</option>
            <option>Corrective</option>
            <option>Predictive</option>
        </select>
    </div>
    <div class="col-md-3">
        <select class="form-select">
            <option>Semua Status</option>
            <option>Selesai</option>
            <option>Proses</option>
            <option>Menunggu</option>
        </select>
    </div>
    <div class="col-md-3">
        <button class="btn btn-primary w-100">Generate Report</button>
    </div>
</div>

<div class="form-section">
    <h5 class="section-title">Rekap Maintenance</h5>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Perangkat</th>
                <th>Tipe Maintenance</th>
                <th>Teknisi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>15 Jun 2026</td>
                <td>M01-ENG-NB005</td>
                <td>Preventive</td>
                <td>Fransiskus Simson</td>
                <td><span class="badge bg-success">Selesai</span></td>
                <td><button class="btn btn-sm btn-outline-primary">Detail</button></td>
            </tr>
            <tr>
                <td>2</td>
                <td>14 Jun 2026</td>
                <td>M04-IT-PC001</td>
                <td>Corrective</td>
                <td>Fransiskus Simson</td>
                <td><span class="badge bg-warning">Proses</span></td>
                <td><button class="btn btn-sm btn-outline-primary">Detail</button></td>
            </tr>
            <tr>
                <td>3</td>
                <td>13 Jun 2026</td>
                <td>M05-MKT-NB002</td>
                <td>Corrective</td>
                <td>Degia Parlopa</td>
                <td><span class="badge bg-info">Menunggu Sparepart</span></td>
                <td><button class="btn btn-sm btn-outline-primary">Detail</button></td>
            </tr>
            <tr>
                <td>4</td>
                <td>10 Jun 2026</td>
                <td>M02-FIN-NB003</td>
                <td>Preventive</td>
                <td>Fransiskus Simson</td>
                <td><span class="badge bg-success">Selesai</span></td>
                <td><button class="btn btn-sm btn-outline-primary">Detail</button></td>
            </tr>
            <tr>
                <td>5</td>
                <td>08 Jun 2026</td>
                <td>M06-HRD-PR001</td>
                <td>Corrective</td>
                <td>Degia Parlopa</td>
                <td><span class="badge bg-success">Selesai</span></td>
                <td><button class="btn btn-sm btn-outline-primary">Detail</button></td>
            </tr>
        </tbody>
    </table>
    <nav>
        <ul class="pagination pagination-sm justify-content-center mt-3">
            <li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
        </ul>
    </nav>
</div>
