<?php
require_once __DIR__ . '/../db.php';

$table = $_GET['table'] ?? '';
if (!$table) die('Table not specified');

$search = $_GET['search'] ?? '';

$table_labels = [
    'level'         => 'Level',
    'directorate'   => 'Directorate',
    'division'      => 'Division',
    'department'    => 'Department',
    'sub_department'=> 'Sub Department',
    'business_unit' => 'Business Unit',
    'corp'          => 'Corp',
    'item'          => 'Item (Category)',
    'site'          => 'Site',
    'employee'      => 'Employee',
    'email'         => 'Email',
    'ad'            => 'Active Directory',
    'workstation'   => 'Workstation',
    'me'            => 'Maintenance Type',
    'task'          => 'Task',
    'wh'            => 'Warehouse',
    'am'            => 'Asset Management',
];

$label = $table_labels[$table] ?? $table;

$pk_overrides = [
    'level'    => 'code', 'directorate' => 'code', 'division' => 'code',
    'department' => 'code', 'sub_department' => 'code', 'business_unit' => 'code',
    'corp' => 'code', 'item' => 'code_item', 'site' => 'id_site',
    'employee' => 'nip', 'email' => 'email', 'ad' => 'username',
    'workstation' => 'id_asset', 'me' => 'id_maintenance',
    'task' => 'id_task', 'wh' => 'id_wh', 'am' => 'barcode',
];
$pk_col = $pk_overrides[$table] ?? 'id';

// Get columns
$stmt = $pdo->query("DESCRIBE `$table`");
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

$skip_cols = ['created_at'];
// q_ws is the only table still using auto-increment id
if ($pk_col === 'id') {
    $skip_cols[] = 'id';
}

// Build search query
$sql = "SELECT * FROM `$table`";
$countSql = "SELECT COUNT(*) FROM `$table`";
$params = [];

if ($search !== '') {
    $likeCols = [];
    foreach ($columns as $col) {
        $f = $col['Field'];
        if (in_array($f, $skip_cols)) continue;
        $likeCols[] = "`$f` LIKE ?";
        $params[] = "%$search%";
    }
    if (!empty($likeCols)) {
        $where = " WHERE " . implode(' OR ', $likeCols);
        $sql .= $where;
        $countSql .= $where;
    }
}

$sql .= " ORDER BY `$pk_col` DESC LIMIT 500";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmtCount = $pdo->prepare($countSql);
$stmtCount->execute($params);
$total = $stmtCount->fetchColumn();

// Foreign key info
$fk_cols = [];
if ($table === 'sub_department') {
    $fk_cols = [
        'department_id' => ['table' => 'department', 'col' => 'code', 'display' => 'name'],
        'division_id' => ['table' => 'division', 'col' => 'code', 'display' => 'name'],
        'directorate_id' => ['table' => 'directorate', 'col' => 'code', 'display' => 'name'],
    ];
}
if ($table === 'employee') {
    $fk_cols = [
        'id_level' => ['table' => 'level', 'col' => 'code', 'display' => 'name'],
        'id_directorate' => ['table' => 'directorate', 'col' => 'code', 'display' => 'name'],
        'id_division' => ['table' => 'division', 'col' => 'code', 'display' => 'name'],
        'id_department' => ['table' => 'department', 'col' => 'code', 'display' => 'name'],
        'id_sub_department' => ['table' => 'sub_department', 'col' => 'code', 'display' => 'name'],
        'business_unit' => ['table' => 'business_unit', 'col' => 'code', 'display' => 'name'],
        'site_unit' => ['table' => 'site', 'col' => 'id_site', 'display' => 'site'],
        'corporate_name' => ['table' => 'corp', 'col' => 'code', 'display' => 'name'],
    ];
}
if ($table === 'email') {
    $fk_cols = ['nip' => ['table' => 'employee', 'col' => 'nip', 'display' => 'name']];
}
if ($table === 'ad') {
    $fk_cols = ['pic_nip' => ['table' => 'employee', 'col' => 'nip', 'display' => 'name']];
}
if ($table === 'workstation') {
    $fk_cols = [
        'pic_nip' => ['table' => 'employee', 'col' => 'nip', 'display' => 'name'],
        'location' => ['table' => 'site', 'col' => 'id_site', 'display' => 'site'],
    ];
}
if ($table === 'task') {
    $fk_cols = ['id_maintenance' => ['table' => 'me', 'col' => 'id_maintenance', 'display' => 'maintenance']];
}
if ($table === 'wh') {
    $fk_cols = [
        'id_asset' => ['table' => 'workstation', 'col' => 'id_asset', 'display' => 'hostname'],
        'wh_site' => ['table' => 'site', 'col' => 'id_site', 'display' => 'site'],
    ];
}
if ($table === 'am') {
    $fk_cols = [
        'barcode' => ['table' => 'workstation', 'col' => 'barcode', 'display' => 'hostname'],
        'code_item' => ['table' => 'item', 'col' => 'code_item', 'display' => 'type'],
        'id_site' => ['table' => 'site', 'col' => 'id_site', 'display' => 'site'],
    ];
}

// Helper: render form field for a column
function renderField($col, $fk_cols, $pdo, $value = '') {
    $field = $col['Field'];
    $is_fk = isset($fk_cols[$field]);
    $is_text = stripos($col['Type'], 'text') !== false;
    $is_enum = stripos($col['Type'], 'enum') !== false;
    $is_date = stripos($col['Type'], 'date') !== false;
    $is_number = stripos($col['Type'], 'decimal') !== false || stripos($col['Type'], 'int') !== false;

    if ($is_fk):
        $fk = $fk_cols[$field];
        $options = $pdo->query("SELECT {$fk['col']}, {$fk['display']} FROM {$fk['table']} ORDER BY {$fk['display']}")->fetchAll(); ?>
        <select name="<?= $field ?>" class="form-select">
            <option value="">-- Pilih --</option>
            <?php foreach ($options as $opt): ?>
                <option value="<?= htmlspecialchars($opt[$fk['col']]) ?>" <?= $value == $opt[$fk['col']] ? 'selected' : '' ?>><?= htmlspecialchars($opt[$fk['display']]) ?></option>
            <?php endforeach; ?>
        </select>
    <?php elseif ($is_enum):
        preg_match_all("/'([^']+)'/", $col['Type'], $matches); ?>
        <select name="<?= $field ?>" class="form-select">
            <option value="">-- Pilih --</option>
            <?php foreach ($matches[1] as $opt): ?>
                <option value="<?= htmlspecialchars($opt) ?>" <?= $value == $opt ? 'selected' : '' ?>><?= htmlspecialchars($opt) ?></option>
            <?php endforeach; ?>
        </select>
    <?php elseif ($is_text): ?>
        <textarea name="<?= $field ?>" class="form-control" rows="2"><?= htmlspecialchars($value) ?></textarea>
    <?php elseif ($is_date): ?>
        <input type="date" name="<?= $field ?>" class="form-control" value="<?= htmlspecialchars($value) ?>">
    <?php elseif ($is_number): ?>
        <input type="number" step="any" name="<?= $field ?>" class="form-control" value="<?= htmlspecialchars($value) ?>">
    <?php else: ?>
        <input type="text" name="<?= $field ?>" class="form-control" maxlength="255" value="<?= htmlspecialchars($value) ?>">
    <?php endif;
}

$searchUrl = htmlspecialchars("?page=settings_table&table=$table");
$searchQuery = htmlspecialchars($search);
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="section-title" style="border:none;margin:0;"><?= htmlspecialchars($label) ?></h5>
        <p class="text-muted mb-0">Total: <?= $total ?> records</p>
    </div>
    <div>
        <a href="?page=settings" class="btn btn-outline-secondary btn-sm me-1">&larr; Kembali</a>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalAdd">+ Tambah</button>
    </div>
</div>

<!-- Search & Export Bar -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <form method="GET" class="d-flex gap-2 flex-grow-1" style="max-width:500px">
        <input type="hidden" name="page" value="settings_table">
        <input type="hidden" name="table" value="<?= $table ?>">
        <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari data..." value="<?= $searchQuery ?>">
        <button class="btn btn-outline-primary btn-sm" type="submit">Cari</button>
        <?php if ($search !== ''): ?>
            <a href="?page=settings_table&table=<?= $table ?>" class="btn btn-outline-secondary btn-sm">Reset</a>
        <?php endif; ?>
    </form>
    <div class="d-flex gap-1 flex-wrap">
        <div class="dropdown">
            <button class="btn btn-success btn-sm dropdown-toggle" data-bs-toggle="dropdown">Export</button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="export_settings.php?table=<?= $table ?>&format=csv&search=<?= urlencode($search) ?>">CSV</a></li>
                <li><a class="dropdown-item" href="export_settings.php?table=<?= $table ?>&format=xlsx&search=<?= urlencode($search) ?>">XLSX</a></li>
                <li><a class="dropdown-item" href="export_settings.php?table=<?= $table ?>&format=xls&search=<?= urlencode($search) ?>">XLS</a></li>
                <li><a class="dropdown-item" href="export_settings.php?table=<?= $table ?>&format=html&search=<?= urlencode($search) ?>">HTML</a></li>
                <li><a class="dropdown-item" href="export_settings.php?table=<?= $table ?>&format=pdf&search=<?= urlencode($search) ?>">PDF</a></li>
            </ul>
        </div>
        <button class="btn btn-info btn-sm text-white" data-bs-toggle="modal" data-bs-target="#modalImport">Import CSV</button>
    </div>
</div>

<div class="form-section">
    <div class="table-responsive">
    <table class="table table-bordered table-hover table-sm align-middle" id="dataTable">
        <thead class="table-secondary">
            <tr>
                <th>No</th>
                <?php foreach ($columns as $col): ?>
                    <?php if (in_array($col['Field'], $skip_cols)) continue; ?>
                    <th><?= htmlspecialchars($col['Field']) ?></th>
                <?php endforeach; ?>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($data)): ?>
            <tr><td colspan="100" class="text-center text-muted">Belum ada data.</td></tr>
            <?php else: ?>
                <?php foreach ($data as $i => $row): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <?php foreach ($columns as $col): ?>
                        <?php if (in_array($col['Field'], $skip_cols)) continue; ?>
                        <td>
                            <?php
                            $val = $row[$col['Field']] ?? '';
                            if (is_null($val) || $val === '') {
                                echo '<span class="text-muted">-</span>';
                            } elseif (strlen($val) > 50) {
                                echo htmlspecialchars(substr($val, 0, 50)) . '...';
                            } else {
                                echo htmlspecialchars($val);
                            }
                            ?>
                        </td>
                    <?php endforeach; ?>
                    <td>
                        <button class="btn btn-sm btn-outline-warning me-1" title="Edit"
                            onclick='editRow(<?= htmlspecialchars(json_encode($row)) ?>, <?= htmlspecialchars(json_encode($columns)) ?>)'>
                            &#9998;
                        </button>
                        <form method="POST" action="process_settings.php" style="display:inline" onsubmit="return confirm('Hapus data ini?')">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="table" value="<?= $table ?>">
                            <input type="hidden" name="pk_col" value="<?= $pk_col ?>">
                            <input type="hidden" name="pk_val" value="<?= htmlspecialchars($row[$pk_col]) ?>">
                            <button class="btn btn-sm btn-outline-danger" title="Hapus">&#128465;</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    </div>
</div>

<!-- Modal ADD -->
<div class="modal fade" id="modalAdd" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah <?= htmlspecialchars($label) ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="process_settings.php" method="POST">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="table" value="<?= $table ?>">
                <input type="hidden" name="pk_col" value="<?= $pk_col ?>">
                <div class="modal-body">
                    <div class="row g-3">
                        <?php foreach ($columns as $col): ?>
                            <?php if (in_array($col['Field'], $skip_cols)) continue; ?>
                            <div class="col-md-6">
                                <label class="form-label"><?= htmlspecialchars($col['Field']) ?><?php if ($col['Null'] === 'NO'): ?><span class="text-danger">*</span><?php endif; ?></label>
                                <?php renderField($col, $fk_cols, $pdo); ?>
                            </div>
                        <?php endforeach; ?>
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

<!-- Modal EDIT -->
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit <?= htmlspecialchars($label) ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="process_settings.php" method="POST">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="table" value="<?= $table ?>">
                <input type="hidden" name="pk_col" value="<?= $pk_col ?>">
                <input type="hidden" name="pk_val" id="edit_pk_val" value="">
                <div class="modal-body">
                    <div class="row g-3" id="editFieldsContainer">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal IMPORT CSV -->
<div class="modal fade" id="modalImport" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import CSV - <?= htmlspecialchars($label) ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="process_settings.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="import_csv">
                <input type="hidden" name="table" value="<?= $table ?>">
                <input type="hidden" name="pk_col" value="<?= $pk_col ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pilih file CSV</label>
                        <input type="file" name="csv_file" class="form-control" accept=".csv" required>
                    </div>
                    <div class="alert alert-info small p-2 mb-0">
                        <strong>Ketentuan:</strong>
                        <ul class="mb-0 ps-3">
                            <li>Baris pertama harus berisi nama kolom (header)</li>
                            <li>Pisahkan dengan koma (,) dan gunakan tanda kutip jika perlu</li>
                            <li>File tidak boleh lebih dari 2MB</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info text-white">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editRow(row, columns) {
    const pkCol = '<?= $pk_col ?>';
    document.getElementById('edit_pk_val').value = row[pkCol] || '';

    let html = '';
    for (const col of columns) {
        const field = col.Field;
        if (field === 'created_at') continue;
        if (field === 'id' && '<?= $pk_col ?>' === 'id') continue;

        const val = row[field] || '';
        const isRequired = col.Null === 'NO';
        const isFK = <?= json_encode(isset($fk_cols) ? 'true' : 'false') ?> && <?= json_encode(array_keys($fk_cols)) ?>.includes(field);
        const isText = col.Type.toLowerCase().includes('text');
        const isEnum = col.Type.toLowerCase().includes('enum');
        const isDate = col.Type.toLowerCase().includes('date');
        const isNumber = col.Type.toLowerCase().includes('decimal') || col.Type.toLowerCase().includes('int');

        html += '<div class="col-md-6">';
        html += '<label class="form-label">' + field + (isRequired ? ' <span class="text-danger">*</span>' : '') + '</label>';

        if (isFK) {
            html += '<select name="' + field + '" class="form-select">';
            html += '<option value="">-- Pilih --</option>';
            const select = document.querySelector('#modalAdd select[name="' + field + '"]');
            if (select) {
                for (const opt of select.options) {
                    const sel = opt.value === val ? 'selected' : '';
                    html += '<option value="' + opt.value + '" ' + sel + '>' + opt.text + '</option>';
                }
            }
            html += '</select>';
        } else if (isEnum) {
            const match = col.Type.match(/'([^']+)'/g);
            html += '<select name="' + field + '" class="form-select">';
            html += '<option value="">-- Pilih --</option>';
            if (match) {
                for (const m of match) {
                    const opt = m.replace(/'/g, '');
                    const sel = opt === val ? 'selected' : '';
                    html += '<option value="' + opt + '" ' + sel + '>' + opt + '</option>';
                }
            }
            html += '</select>';
        } else if (isText) {
            html += '<textarea name="' + field + '" class="form-control" rows="2">' + escapeHtml(val) + '</textarea>';
        } else if (isDate) {
            html += '<input type="date" name="' + field + '" class="form-control" value="' + escapeHtml(val) + '">';
        } else if (isNumber) {
            html += '<input type="number" step="any" name="' + field + '" class="form-control" value="' + escapeHtml(val) + '">';
        } else {
            html += '<input type="text" name="' + field + '" class="form-control" maxlength="255" value="' + escapeHtml(val) + '">';
        }
        html += '</div>';
    }
    document.getElementById('editFieldsContainer').innerHTML = html;

    const modal = new bootstrap.Modal(document.getElementById('modalEdit'));
    modal.show();
}

function escapeHtml(str) {
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
}
</script>
