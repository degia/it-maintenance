<form action="process.php" method="POST">
    <div class="form-section">
        <h5 class="section-title">Informasi Pengguna</h5>
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Nama User</label><input type="text" name="user_name"
                    class="form-control" value="Nurcahyo Setyo Utomo" required></div>
            <div class="col-md-6"><label class="form-label">NIK User</label><input type="text" name="user_nik"
                    class="form-control"></div>
            <div class="col-md-6"><label class="form-label">Department</label><input type="text"
                    name="department" class="form-control" value="Engineering [Manager]"></div>
            <div class="col-md-6"><label class="form-label">Site / B. Unit</label><input type="text"
                    name="site_unit" class="form-control" value="PIK Avenue / PT. MAP"></div>
            <div class="col-md-6"><label class="form-label">Alamat Email</label><input type="email" name="email"
                    class="form-control" value="nurcahyo.utomo@asri.co.id"></div>
            <div class="col-md-6"><label class="form-label">No. Telepon</label><input type="text" name="phone"
                    class="form-control"></div>
        </div>
    </div>

    <div class="form-section">
        <h5 class="section-title">Informasi Perangkat</h5>
        <div class="row g-3">
            <div class="col-md-4"><label class="form-label">No. Formulir</label><input type="text"
                    name="form_no" class="form-control" value="001/IT/M01-ENG-NB005/260526" required></div>
            <div class="col-md-4"><label class="form-label">Kategori</label><select name="device_category"
                    class="form-select">
                    <option>Laptop</option>
                    <option>Desktop</option>
                    <option>Printer</option>
                </select></div>
            <div class="col-md-4"><label class="form-label">Brand</label><input type="text" name="device_brand"
                    class="form-control" value="Zyrex"></div>
            <div class="col-md-6"><label class="form-label">Tipe</label><input type="text" name="device_type"
                    class="form-control" value="Cruiser 20 1425H-16S5P-5"></div>
            <div class="col-md-6"><label class="form-label">Nama Perangkat</label><input type="text"
                    name="device_name" class="form-control" value="M01-ENG-NB005"></div>
            <div class="col-md-6"><label class="form-label">No. Serial</label><input type="text"
                    name="serial_number" class="form-control" value="CRUB05Z039"></div>
            <div class="col-md-6"><label class="form-label">No. Asset</label><input type="text"
                    name="asset_number" class="form-control" value="PIKMAPEQP250009"></div>
        </div>
    </div>

    <div class="form-section">
        <h5 class="section-title">Pemeriksaan Hardware</h5>
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>Komponen</th>
                    <th>Kondisi (✓ Baik / X Tidak Baik)</th>
                    <th>Spesifikasi / Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Processor</td>
                    <td><select name="hw[Processor][kondisi]" class="form-select form-select-sm">
                            <option>BAIK</option>
                            <option>TIDAK BAIK</option>
                        </select></td>
                    <td><input type="text" name="hw[Processor][ket]" class="form-control form-control-sm"
                            value="i5-12450H"></td>
                </tr>
                <tr>
                    <td>Mainboard</td>
                    <td><select name="hw[Mainboard][kondisi]" class="form-select form-select-sm">
                            <option>BAIK</option>
                            <option>TIDAK BAIK</option>
                        </select></td>
                    <td><input type="text" name="hw[Mainboard][ket]" class="form-control form-control-sm"
                            value="GOOD"></td>
                </tr>
                <tr>
                    <td>Monitor / LCD</td>
                    <td><select name="hw[Monitor][kondisi]" class="form-select form-select-sm">
                            <option>BAIK</option>
                            <option>TIDAK BAIK</option>
                        </select></td>
                    <td><input type="text" name="hw[Monitor][ket]" class="form-control form-control-sm"
                            value="GOOD"></td>
                </tr>
                <tr>
                    <td>Battery</td>
                    <td><select name="hw[Battery][kondisi]" class="form-select form-select-sm">
                            <option>BAIK</option>
                            <option>TIDAK BAIK</option>
                        </select></td>
                    <td><input type="text" name="hw[Battery][ket]" class="form-control form-control-sm"
                            value="4500 mAh, 100%"></td>
                </tr>
                <tr>
                    <td>Memory (RAM)</td>
                    <td><select name="hw[Memory][kondisi]" class="form-select form-select-sm">
                            <option>BAIK</option>
                            <option>TIDAK BAIK</option>
                        </select></td>
                    <td><input type="text" name="hw[Memory][ket]" class="form-control form-control-sm"
                            value="16 GB [8+8]"></td>
                </tr>
                <tr>
                    <td>Disk (Storage)</td>
                    <td><select name="hw[Disk][kondisi]" class="form-select form-select-sm">
                            <option>BAIK</option>
                            <option>TIDAK BAIK</option>
                        </select></td>
                    <td><input type="text" name="hw[Disk][ket]" class="form-control form-control-sm"
                            value="SSD 512 GB"></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="form-section">
        <h5 class="section-title">Pemeriksaan Aplikasi & OS</h5>
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Operating System</label><input type="text"
                    name="os_name" class="form-control" value="Windows 11 Professional"></div>
            <div class="col-md-6"><label class="form-label">Kinerja Sistem</label><select
                    name="system_performance" class="form-select">
                    <option>GOOD</option>
                    <option>POOR</option>
                </select></div>
        </div>
        <hr>
        <div class="row g-2">
            <div class="col-md-3"><label class="form-label">Antivirus (Kaspersky)</label><select
                    name="sw[Antivirus]" class="form-select form-select-sm">
                    <option>Licensed</option>
                    <option>Not Installed</option>
                </select></div>
            <div class="col-md-3"><label class="form-label">Manage Engine</label><select name="sw[ManageEngine]"
                    class="form-select form-select-sm">
                    <option>Connected</option>
                    <option>Disconnected</option>
                </select></div>
            <div class="col-md-3"><label class="form-label">Microsoft Office 365</label><select
                    name="sw[Office365]" class="form-select form-select-sm">
                    <option>Installed</option>
                    <option>Not Installed</option>
                </select></div>
            <div class="col-md-3"><label class="form-label">Microsoft Teams</label><select name="sw[Teams]"
                    class="form-select form-select-sm">
                    <option>Installed</option>
                    <option>Not Installed</option>
                </select></div>
            <div class="col-md-3"><label class="form-label">Anydesk</label><select name="sw[Anydesk]"
                    class="form-select form-select-sm">
                    <option>Installed</option>
                    <option>Not Installed</option>
                </select></div>
        </div>
    </div>

    <div class="form-section">
        <h5 class="section-title">Tindakan</h5>
        <div class="form-check"><input class="form-check-input" type="checkbox" id="action-install-os"
                name="actions[]" value="Install/Repair/Reset OS" title="Install, Repair, or Reset OS"> <label
                class="form-check-label" for="action-install-os">Install / Repair / Reset OS</label></div>
        <div class="form-check"><input class="form-check-input" type="checkbox" id="action-account"
                name="actions[]" value="Create/Delete Account" title="Create or Delete Account"> <label
                class="form-check-label" for="action-account">Create / Delete Account</label></div>
        <div class="form-check"><input class="form-check-input" type="checkbox" id="action-backup-data"
                name="actions[]" value="Delete/Backup Data" title="Delete or Backup Data"> <label
                class="form-check-label" for="action-backup-data">Delete / Backup Data</label></div>
        <div class="form-check"><input class="form-check-input" type="checkbox" id="action-sparepart"
                name="actions[]" value="Service/Pergantian Sparepart" title="Service or Replace Sparepart"> <label
                class="form-check-label" for="action-sparepart">Service / Pergantian Sparepart</label></div>
        <div class="form-check"><input class="form-check-input" type="checkbox" id="action-exit-clearance"
                name="actions[]" value="Pengecekan EXIT CLEARANCE" title="Pengecekan untuk EXIT CLEARANCE"> <label
                class="form-check-label" for="action-exit-clearance">Pengecekan untuk EXIT CLEARANCE</label></div>
    </div>

    <div class="form-section">
        <h5 class="section-title">Catatan & Persetujuan</h5>
        <div class="mb-3">
            <label for="notes" class="form-label">Catatan / Rekomendasi</label>
            <textarea id="notes" name="notes" class="form-control" title="Catatan dan rekomendasi pemeriksaan"
                placeholder="Masukkan catatan atau rekomendasi" rows="3">Direkomendasikan: Asset akan digunakan Oleh Regil Yanwar Fadilah. Engineering Staff. Pengecekan untuk EXIT CLEARANCE.</textarea>
        </div>
        <div class="row g-3">
            <div class="col-md-4"><label class="form-label">Diperiksa Oleh (IT Staff)</label><input type="text"
                    name="inspector_name" class="form-control" value="Fransiskus Simson"></div>
            <div class="col-md-4"><label class="form-label">Diketahui Oleh (Manager)</label><input type="text"
                    name="manager_name" class="form-control" value="Nurcahyo Setyo Utomo"></div>
            <div class="col-md-4"><label class="form-label">Disetujui Oleh (SPV)</label><input type="text"
                    name="spv_name" class="form-control" value="Degia Parlopa"></div>
            <div class="col-md-4"><label class="form-label">Tanggal Pemeriksaan</label><input type="date"
                    name="inspection_date" class="form-control" value="2026-05-26" required></div>
        </div>
    </div>

    <div class="text-center mb-5">
        <button type="submit" class="btn btn-primary btn-lg">Simpan Data ke Database</button>
    </div>
</form>
