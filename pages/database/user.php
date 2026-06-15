<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="section-title" style="border:none;margin:0;">Data User</h5>
    </div>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalUser">+ Tambah User</button>
</div>

<div class="form-section">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama User</th>
                <th>Department</th>
                <th>Site / B. Unit</th>
                <th>Email</th>
                <th>No. Telepon</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>12345</td>
                <td>Nurcahyo Setyo Utomo</td>
                <td>Engineering [Manager]</td>
                <td>PIK Avenue / PT. MAP</td>
                <td>nurcahyo.utomo@asri.co.id</td>
                <td>08123456789</td>
                <td>
                    <button class="btn btn-sm btn-outline-warning">Edit</button>
                    <button class="btn btn-sm btn-outline-danger">Hapus</button>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>12346</td>
                <td>Fransiskus Simson</td>
                <td>IT</td>
                <td>PIK Avenue / PT. MAP</td>
                <td>fransiskus@asri.co.id</td>
                <td>08123456788</td>
                <td>
                    <button class="btn btn-sm btn-outline-warning">Edit</button>
                    <button class="btn btn-sm btn-outline-danger">Hapus</button>
                </td>
            </tr>
            <tr>
                <td>3</td>
                <td>12347</td>
                <td>Degia Parlopa</td>
                <td>IT</td>
                <td>PIK Avenue / PT. MAP</td>
                <td>degia@asri.co.id</td>
                <td>08123456787</td>
                <td>
                    <button class="btn btn-sm btn-outline-warning">Edit</button>
                    <button class="btn btn-sm btn-outline-danger">Hapus</button>
                </td>
            </tr>
            <tr>
                <td>4</td>
                <td>12348</td>
                <td>Regil Yanwar Fadilah</td>
                <td>Engineering Staff</td>
                <td>PIK Avenue / PT. MAP</td>
                <td>regil@asri.co.id</td>
                <td>08123456786</td>
                <td>
                    <button class="btn btn-sm btn-outline-warning">Edit</button>
                    <button class="btn btn-sm btn-outline-danger">Hapus</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="modal fade" id="modalUser" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">NIK</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama User</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Department</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Site / B. Unit</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No. Telepon</label>
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
