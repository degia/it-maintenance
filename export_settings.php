<?php
require_once 'includes/auth.php';
require_login();
require_once 'db.php';

$table = $_GET['table'] ?? '';
$format = $_GET['format'] ?? 'csv';
$search = $_GET['search'] ?? '';

$allowed_tables = ['level','directorate','division','department','sub_department','business_unit','corp','item','site','employee','email','ad','workstation','q_ws','me','task','wh','am'];
if (!in_array($table, $allowed_tables)) {
    die('Invalid table');
}

$allowed_formats = ['csv', 'xlsx', 'xls', 'html', 'pdf'];
if (!in_array($format, $allowed_formats)) {
    $format = 'csv';
}

// Get columns
$stmt = $pdo->query("DESCRIBE `$table`");
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

$skip_cols = ['created_at'];
$pk_overrides = [
    'level'    => 'code', 'directorate' => 'code', 'division' => 'code',
    'department' => 'code', 'sub_department' => 'code', 'business_unit' => 'code',
    'corp' => 'code', 'item' => 'code_item', 'site' => 'id_site',
    'employee' => 'nip', 'email' => 'email', 'ad' => 'username',
    'workstation' => 'id_asset', 'me' => 'id_maintenance',
    'task' => 'id_task', 'wh' => 'id_wh', 'am' => 'barcode',
];
$pk_col = $pk_overrides[$table] ?? 'id';
if ($pk_col === 'id') {
    $skip_cols[] = 'id';
}

// Build query with search
$selectCols = [];
foreach ($columns as $col) {
    if (!in_array($col['Field'], $skip_cols)) {
        $selectCols[] = "`{$col['Field']}`";
    }
}

$sql = "SELECT " . implode(', ', $selectCols) . " FROM `$table`";
$params = [];

if ($search !== '') {
    $likeCols = [];
    foreach ($columns as $col) {
        if (!in_array($col['Field'], $skip_cols)) {
            $likeCols[] = "`{$col['Field']}` LIKE ?";
            $params[] = "%$search%";
        }
    }
    if (!empty($likeCols)) {
        $sql .= " WHERE " . implode(' OR ', $likeCols);
    }
}

$sql .= " ORDER BY `$pk_col` DESC LIMIT 5000";

$data = $pdo->prepare($sql);
$data->execute($params);
$rows = $data->fetchAll(PDO::FETCH_ASSOC);

// Column display names
$displayCols = [];
foreach ($columns as $col) {
    if (!in_array($col['Field'], $skip_cols)) {
        $displayCols[] = $col['Field'];
    }
}

// Generate export filename
$filename = $table . '_' . date('Ymd_His');

// ---- FORMAT HANDLERS ----

if ($format === 'csv') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '.csv"');

    $output = fopen('php://output', 'w');
    fputs($output, "\xEF\xBB\xBF"); // BOM for UTF-8 Excel
    fputcsv($output, $displayCols);

    foreach ($rows as $row) {
        $line = [];
        foreach ($displayCols as $col) {
            $line[] = $row[$col] ?? '';
        }
        fputcsv($output, $line);
    }
    fclose($output);
    exit;
}

if ($format === 'html') {
    header('Content-Type: text/html; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '.html"');
    ?>
    <!DOCTYPE html>
    <html><head><meta charset="UTF-8"><title><?= htmlspecialchars($table) ?></title>
    <style>table{border-collapse:collapse;width:100%;font-family:sans-serif;font-size:12px}
    th,td{border:1px solid #999;padding:4px 8px;text-align:left}
    th{background:#4472C4;color:#fff}</style></head>
    <body><h2><?= htmlspecialchars($table) ?></h2>
    <table><thead><tr><?php foreach ($displayCols as $c): ?><th><?= htmlspecialchars($c) ?></th><?php endforeach; ?></tr></thead>
    <tbody><?php foreach ($rows as $row): ?><tr><?php foreach ($displayCols as $c): ?><td><?= htmlspecialchars($row[$c] ?? '') ?></td><?php endforeach; ?></tr><?php endforeach; ?></tbody>
    </table></body></html>
    <?php
    exit;
}

if ($format === 'xls') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="' . $filename . '.xls"');
    ?>
    <html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
    <head><meta charset="UTF-8"><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>Sheet1</x:Name></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]-->
    <style>table{border-collapse:collapse}th{background:#4472C4;color:#fff;font-weight:bold}td,th{border:1px solid #999;padding:3px 6px;font-size:11px;font-family:Calibri}</style></head>
    <body><table>
    <tr><?php foreach ($displayCols as $c): ?><th><?= htmlspecialchars($c) ?></th><?php endforeach; ?></tr>
    <?php foreach ($rows as $row): ?><tr><?php foreach ($displayCols as $c): ?><td><?= htmlspecialchars($row[$c] ?? '') ?></td><?php endforeach; ?></tr><?php endforeach; ?>
    </table></body></html>
    <?php
    exit;
}

if ($format === 'xlsx') {
    require_once __DIR__ . '/includes/export_helper.php';

    $xlsx = new SimpleXLSX();
    $xlsx->setHeader($displayCols);
    foreach ($rows as $row) {
        $line = [];
        foreach ($displayCols as $col) {
            $line[] = $row[$col] ?? '';
        }
        $xlsx->addRow($line);
    }

    $tmpFile = tempnam(sys_get_temp_dir(), 'xlsx');
    $xlsx->output($tmpFile);

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '.xlsx"');
    header('Content-Length: ' . filesize($tmpFile));
    readfile($tmpFile);
    unlink($tmpFile);
    exit;
}

if ($format === 'pdf') {
    require_once __DIR__ . '/includes/export_helper.php';

    $pdf = new SimplePDF();

    // Calculate column widths
    $numCols = count($displayCols);
    $pageW = 510;
    $colW = floor($pageW / $numCols);
    $colWidths = array_fill(0, $numCols, $colW);
    $colWidths[$numCols - 1] = $pageW - ($colW * ($numCols - 1)); // last column fills remaining

    // Build header as assoc for addTable
    $header = [];
    foreach ($displayCols as $i => $c) {
        $header[$c] = $c;
    }

    // Build rows as assoc
    $pdfRows = [];
    foreach ($rows as $row) {
        $pdfRow = [];
        foreach ($displayCols as $col) {
            $val = $row[$col] ?? '';
            if (strlen($val) > 30) $val = substr($val, 0, 30) . '...';
            $pdfRow[$col] = $val;
        }
        $pdfRows[] = $pdfRow;
    }

    $pdf->addTable($header, $pdfRows, 50, 740, $colWidths);

    $tmpFile = tempnam(sys_get_temp_dir(), 'pdf');
    $pdf->output($tmpFile);

    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . $filename . '.pdf"');
    header('Content-Length: ' . filesize($tmpFile));
    readfile($tmpFile);
    unlink($tmpFile);
    exit;
}

header("Location: index.php?page=settings_table&table=$table" . ($search ? "&search=" . urlencode($search) : ''));
