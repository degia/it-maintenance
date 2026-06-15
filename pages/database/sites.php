<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="section-title" style="border:none;margin:0;">Data Sites</h5>
    </div>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalSite">+ Tambah Site</button>
</div>

<div class="form-section">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Site</th>
                <th>Nama Site</th>
                <th>Alamat</th>
                <th>Kota</th>
                <th>Provinsi</th>
                <th>Kontak</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>PIK</td>
                <td>PIK Avenue</td>
                <td>Jl. Pantai Indah Kapuk</td>
                <td>Jakarta Utara</td>
                <td>DKI Jakarta</td>
                <td>021-1234567</td>
                <td>
                    <button class="btn btn-sm btn-outline-warning">Edit</button>
                    <button class="btn btn-sm btn-outline-danger">Hapus</button>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>BSD</td>
                <td>BSD Green Office Park</td>
                <td>Jl. BSD Raya</td>
                <td>Tangerang Selatan</td>
                <td>Banten</td>
                <td>021-7654321</td>
                <td>
                    <button class="btn btn-sm btn-outline-warning">Edit</button>
                    <button class="btn btn-sm btn-outline-danger">Hapus</button>
                </td>
            </tr>
            <tr>
                <td>3</td>
                <td>KNO</td>
                <td>Kuningan Office</td>
                <td>Jl. HR Rasuna Said</td>
                <td>Jakarta Selatan</td>
                <td>DKI Jakarta</td>
                <td>021-5555555</td>
                <td>
                    <button class="btn btn-sm btn-outline-warning">Edit</button>
                    <button class="btn btn-sm btn-outline-danger">Hapus</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="modal fade" id="modalSite" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Site</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Kode Site</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Site</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kota</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Provinsi</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kontak</label>
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
