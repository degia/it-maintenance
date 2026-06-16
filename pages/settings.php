<?php
require_once __DIR__ . '/../db.php';

$tables = [
    'level'         => ['label' => 'Level',         'icon' => '&#9733;', 'desc' => 'Level jabatan karyawan'],
    'directorate'   => ['label' => 'Directorate',   'icon' => '&#9733;', 'desc' => 'Data direktorat'],
    'division'      => ['label' => 'Division',      'icon' => '&#9733;', 'desc' => 'Data divisi'],
    'department'    => ['label' => 'Department',    'icon' => '&#9733;', 'desc' => 'Data departemen'],
    'sub_department'=> ['label' => 'Sub Department', 'icon' => '&#9733;', 'desc' => 'Data sub departemen'],
    'business_unit' => ['label' => 'Business Unit', 'icon' => '&#9733;', 'desc' => 'Data business unit'],
    'corp'          => ['label' => 'Corp',          'icon' => '&#9733;', 'desc' => 'Data perusahaan'],
    'item'          => ['label' => 'Item (Category)', 'icon' => '&#9881;', 'desc' => 'Kategori asset'],
    'site'          => ['label' => 'Site',          'icon' => '&#8962;', 'desc' => 'Data lokasi/site'],
    'employee'      => ['label' => 'Employee',      'icon' => '&#128101;', 'desc' => 'Data karyawan'],
    'email'         => ['label' => 'Email',         'icon' => '&#9993;', 'desc' => 'Data email'],
    'ad'            => ['label' => 'Active Directory','icon' => '&#128274;', 'desc' => 'Data AD accounts'],
    'workstation'   => ['label' => 'Workstation',   'icon' => '&#128187;', 'desc' => 'Data asset perangkat'],
    'me'            => ['label' => 'Maintenance Type','icon' => '&#9881;', 'desc' => 'Tipe maintenance'],
    'task'          => ['label' => 'Task',          'icon' => '&#128203;', 'desc' => 'Data jadwal task'],
    'wh'            => ['label' => 'Warehouse',     'icon' => '&#128230;', 'desc' => 'Data status gudang'],
    'am'            => ['label' => 'Asset Management','icon' => '&#128188;', 'desc' => 'Data PR/PO/Acquisition'],
];
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="section-title" style="border:none;margin:0;">Database Settings</h5>
        <p class="text-muted mb-0">Kelola data master dan referensi sistem.</p>
    </div>
</div>

<div class="row g-3">
    <?php foreach ($tables as $key => $t): ?>
    <div class="col-md-4 col-lg-3">
        <a href="?page=settings_<?= $key ?>" class="text-decoration-none">
            <div class="card card-dashboard h-100">
                <div class="card-body">
                    <div class="card-icon" style="background:#e0e7ff;color:#4338ca;width:40px;height:40px;font-size:1.2rem;">
                        <?= $t['icon'] ?>
                    </div>
                    <h6 class="fw-bold mt-2 mb-1"><?= $t['label'] ?></h6>
                    <p class="card-label" style="font-size:0.8rem;"><?= $t['desc'] ?></p>
                </div>
            </div>
        </a>
    </div>
    <?php endforeach; ?>
</div>
