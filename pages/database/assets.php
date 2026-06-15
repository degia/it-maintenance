<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="section-title" style="border:none;margin:0;">Data Assets</h5>
    </div>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalAsset">+ Tambah Asset</button>
</div>

<div class="form-section">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>No. Asset</th>
                <th>Nama Perangkat</th>
                <th>Kategori</th>
                <th>Brand</th>
                <th>Tipe</th>
                <th>Serial Number</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>PIKMAPEQP250009</td>
                <td>M01-ENG-NB005</td>
                <td>Laptop</td>
                <td>Zyrex</td>
                <td>Cruiser 20 1425H-16S5P-5</td>
                <td>CRUB05Z039</td>
                <td><span class="badge bg-success">Aktif</span></td>
                <td>
                    <button class="btn btn-sm btn-outline-warning">Edit</button>
                    <button class="btn btn-sm btn-outline-danger">Hapus</button>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>PIKMAPEQP250010</td>
                <td>M02-FIN-NB003</td>
                <td>Laptop</td>
                <td>Dell</td>
                <td>Latitude 3420</td>
                <td>DELL123456</td>
                <td><span class="badge bg-success">Aktif</span></td>
                <td>
                    <button class="btn btn-sm btn-outline-warning">Edit</button>
                    <button class="btn btn-sm btn-outline-danger">Hapus</button>
                </td>
            </tr>
            <tr>
                <td>3</td>
                <td>PIKMAPEQP250011</td>
                <td>M03-HRD-DT001</td>
                <td>Desktop</td>
                <td>Lenovo</td>
                <td>ThinkCentre M720</td>
                <td>LENO123456</td>
                <td><span class="badge bg-warning">Maintenance</span></td>
                <td>
                    <button class="btn btn-sm btn-outline-warning">Edit</button>
                    <button class="btn btn-sm btn-outline-danger">Hapus</button>
                </td>
            </tr>
            <tr>
                <td>4</td>
                <td>PIKMAPEQP250012</td>
                <td>M04-IT-PC001</td>
                <td>Desktop</td>
                <td>HP</td>
                <td>EliteDesk 800</td>
                <td>HP12345678</td>
                <td><span class="badge bg-danger">Rusak</span></td>
                <td>
                    <button class="btn btn-sm btn-outline-warning">Edit</button>
                    <button class="btn btn-sm btn-outline-danger">Hapus</button>
                </td>
            </tr>
            <tr>
                <td>5</td>
                <td>PIKMAPEQP250013</td>
                <td>M06-HRD-PR001</td>
                <td>Printer</td>
                <td>Epson</td>
                <td>L3210</td>
                <td>EPS12345678</td>
                <td><span class="badge bg-success">Aktif</span></td>
                <td>
                    <button class="btn btn-sm btn-outline-warning">Edit</button>
                    <button class="btn btn-sm btn-outline-danger">Hapus</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="modal fade" id="modalAsset" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Asset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">No. Asset</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Perangkat</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-select">
                            <option>Laptop</option>
                            <option>Desktop</option>
                            <option>Printer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Brand</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipe</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Serial Number</label>
                        <input type="text" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>
