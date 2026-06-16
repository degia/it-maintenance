<?php
require_once 'includes/auth.php';
require_login();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php?page=settings");
    exit;
}

$action = $_POST['action'] ?? '';
$table  = $_POST['table'] ?? '';

$allowed_tables = ['level','directorate','division','department','sub_department','business_unit','corp','item','site','employee','email','ad','workstation','q_ws','me','task','wh','am'];
if (!in_array($table, $allowed_tables)) {
    header("Location: index.php?page=settings");
    exit;
}

$redirect = "index.php?page=settings_table&table=$table";

if ($action === 'delete') {
    $pk_col = $_POST['pk_col'] ?? 'id';
    $pk_val = $_POST['pk_val'] ?? '';
    if ($pk_val !== '') {
        try {
            $stmt = $pdo->prepare("DELETE FROM `$table` WHERE `$pk_col` = ?");
            $stmt->execute([$pk_val]);
            echo "<script>alert('Data berhasil dihapus!'); window.location.href='$redirect';</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Error: " . addslashes($e->getMessage()) . "'); window.location.href='$redirect';</script>";
        }
    }
    exit;
}

if ($action === 'edit') {
    $pk_col = $_POST['pk_col'] ?? 'id';
    $pk_val = $_POST['pk_val'] ?? '';
    $sets = [];
    $values = [];

    foreach ($_POST as $key => $val) {
        if (in_array($key, ['action', 'table', 'pk_col', 'pk_val'])) continue;
        $sets[] = "`$key` = ?";
        $values[] = $val;
    }

    if (!empty($sets) && $pk_val !== '') {
        $sql = "UPDATE `$table` SET " . implode(', ', $sets) . " WHERE `$pk_col` = ?";
        $values[] = $pk_val;
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute($values);
            echo "<script>alert('Data berhasil diperbarui!'); window.location.href='$redirect';</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Error: " . addslashes($e->getMessage()) . "'); window.location.href='$redirect';</script>";
        }
    }
    exit;
}

if ($action === 'import_csv') {
    if (!isset($_FILES['csv_file']) || $_FILES['csv_file']['error'] !== UPLOAD_ERR_OK) {
        echo "<script>alert('Gagal mengupload file.'); window.location.href='$redirect';</script>";
        exit;
    }

    $tmpPath = $_FILES['csv_file']['tmp_name'];
    $handle = fopen($tmpPath, 'r');
    if (!$handle) {
        echo "<script>alert('Tidak dapat membaca file.'); window.location.href='$redirect';</script>";
        exit;
    }

    // Read header row
    $header = fgetcsv($handle);
    if (!$header) {
        echo "<script>alert('File CSV kosong atau tidak valid.'); window.location.href='$redirect';</script>";
        exit;
    }

    // Clean BOM and trim headers
    $header = array_map(function($h) {
        return trim(str_replace("\xEF\xBB\xBF", '', $h));
    }, $header);

    // Validate columns exist in table
    $stmt = $pdo->query("DESCRIBE `$table`");
    $dbCols = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

    $validCols = [];
    foreach ($header as $h) {
        if (in_array($h, $dbCols) && !in_array($h, ['created_at'])) {
            $validCols[] = $h;
        }
    }

    if (empty($validCols)) {
        echo "<script>alert('Tidak ada kolom yang cocok dengan struktur tabel.'); window.location.href='$redirect';</script>";
        exit;
    }

    // Prepare INSERT
    $placeholders = implode(', ', array_fill(0, count($validCols), '?'));
    $colNames = implode(', ', array_map(function($c) { return "`$c`"; }, $validCols));
    $insertSql = "INSERT IGNORE INTO `$table` ($colNames) VALUES ($placeholders)";
    $stmt = $pdo->prepare($insertSql);

    $imported = 0;
    $errors = 0;

    while (($row = fgetcsv($handle)) !== false) {
        if (count($row) < count($validCols)) {
            $errors++;
            continue;
        }

        $values = [];
        foreach ($validCols as $i => $col) {
            $values[] = $row[$i] ?? '';
        }

        try {
            $stmt->execute($values);
            if ($stmt->rowCount() > 0) $imported++;
            else $errors++;
        } catch (PDOException $e) {
            $errors++;
        }
    }

    fclose($handle);
    echo "<script>alert('Import selesai! Berhasil: $imported, Gagal: $errors'); window.location.href='$redirect';</script>";
    exit;
}

if ($action === 'add') {
    $columns = [];
    $values = [];
    $placeholders = [];

    foreach ($_POST as $key => $val) {
        if (in_array($key, ['action', 'table', 'pk_col'])) continue;
        $columns[] = "`$key`";
        $values[] = $val;
        $placeholders[] = '?';
    }

    if (!empty($columns)) {
        $sql = "INSERT INTO `$table` (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $placeholders) . ")";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute($values);
            echo "<script>alert('Data berhasil ditambahkan!'); window.location.href='$redirect';</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Error: " . addslashes($e->getMessage()) . "'); window.location.href='$redirect';</script>";
        }
    }
    exit;
}

header("Location: $redirect");
