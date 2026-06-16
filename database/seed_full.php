<?php
/**
 * Seed all 18 reference tables from structure_data.xlsx
 * Usage: php database/seed_full.php
 */

require_once __DIR__ . '/../db.php';

$path = __DIR__ . '/../data/structure_data.xlsx';
$zip = new ZipArchive;
if ($zip->open($path) !== true) die("Failed to open xlsx\n");

// Shared strings
$sharedStrings = [];
if (($index = $zip->locateName('xl/sharedStrings.xml')) !== false) {
    $xml = simplexml_load_string($zip->getFromIndex($index));
    foreach ($xml->si as $si) $sharedStrings[] = (string)$si->t;
}

function colFromRef($ref) {
    preg_match('/^([A-Z]+)/', $ref, $m);
    $col = 0;
    foreach (str_split($m[1]) as $ch) $col = $col * 26 + (ord($ch) - 64);
    return $col - 1; // 0-indexed: A=0, B=1, C=2 ...
}

function cellValue($cell, $ss) {
    $t = (string)$cell['t'];
    $v = (string)$cell->v;
    return $v === '' ? '' : ($t === 's' ? ($ss[(int)$v] ?? $v) : $v);
}

function parseSheet($zip, $sNum, $ss) {
    $c = $zip->getFromName("xl/worksheets/sheet{$sNum}.xml");
    if (!$c) return [];
    $x = simplexml_load_string($c);
    $rows = [];
    foreach ($x->sheetData->row as $row) {
        $vals = [];
        foreach ($row->c as $cell) {
            $ref = (string)$cell['r'];
            $vals[colFromRef($ref)] = cellValue($cell, $ss);
        }
        // Keep row if at least one non-empty value
        foreach ($vals as $v) { if ($v !== '') { $rows[] = $vals; break; } }
    }
    return $rows;
}

function ins($pdo, $table, $data) {
    $data = array_filter($data, fn($v) => $v !== '' && $v !== null);
    if (empty($data)) return false;
    $cols = array_keys($data);
    $ph = array_fill(0, count($cols), '?');
    try {
        $s = $pdo->prepare("INSERT IGNORE INTO `$table` (`" . implode('`,`', $cols) . "`) VALUES (" . implode(',', $ph) . ")");
        $s->execute(array_values($data));
        return $s->rowCount() > 0;
    } catch (PDOException $e) {
        echo "  SQL Error: " . $e->getMessage() . "\n";
        return false;
    }
}

// get all workstation column names from schema
function getWsColumns($pdo) {
    $s = $pdo->query("SHOW COLUMNS FROM workstation");
    $cols = [];
    foreach ($s as $r) $cols[] = $r['Field'];
    return $cols;
}

$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');

// ============================================================
$sheetNames = [];
$wbXml = simplexml_load_string($zip->getFromName('xl/workbook.xml'));
foreach ($wbXml->sheets->sheet as $sheet) {
    $attrs = $sheet->attributes();
    $sheetNames[] = (string)$attrs['name'];
}
echo "Sheets: " . implode(', ', $sheetNames) . "\n\n";

$wsSchemaCols = null;
$employeeNips = []; // track nips for auto-generation

// ============================================================
foreach ($sheetNames as $idx => $sName) {
    $sNum = $idx + 1;
    $rows = parseSheet($zip, $sNum, $sharedStrings);
    if (empty($rows)) { echo "'$sName' -> no data\n"; continue; }

    switch ($sName) {
        // === SIMPLE REFERENCE TABLES (index 0 = header, 1+ = data) ===
        case 'LEVEL':
        case 'DIRECTORATE':
        case 'DIVISION':
        case 'DEPARTEMENT':
        case 'BUSINESS-UNIT':
        case 'CORP':
        case 'ITEM':
            $table = ['LEVEL' => 'level', 'DIRECTORATE' => 'directorate', 'DIVISION' => 'division',
                      'DEPARTEMENT' => 'department', 'BUSINESS-UNIT' => 'business_unit', 'CORP' => 'corp',
                      'ITEM' => 'item'][$sName];
            // Col: A=code(1), B=name(2), C=note(3)
            $c = 0;
            for ($i = 1; $i < count($rows); $i++) {
                $r = $rows[$i];
                $d = ['code' => $r[1] ?? '', 'name' => $r[2] ?? '', 'note' => $r[3] ?? ''];
                if ($table === 'item') {
                    $d = ['code_item' => $r[1] ?? '', 'type' => $r[2] ?? '', 'category' => $r[3] ?? ''];
                }
                if (ins($pdo, $table, $d)) $c++;
            }
            echo "'$sName' -> $c inserted\n";
            break;

        // === SITE: row 0=header, 1+=data ===
        case 'SITE':
            $c = 0;
            for ($i = 1; $i < count($rows); $i++) {
                $r = $rows[$i];
                if (ins($pdo, 'site', [
                    'id_site' => $r[1] ?? '',
                    'site' => $r[2] ?? '',
                    'business_unit' => $r[3] ?? '',
                    'company' => $r[4] ?? '',
                    'country' => $r[5] ?? 'Indonesia',
                    'provincy' => $r[6] ?? '',
                    'city' => $r[7] ?? '',
                    'address' => $r[8] ?? '',
                    'url_maps' => $r[9] ?? '',
                ])) $c++;
            }
            echo "'$sName' -> $c inserted\n";
            break;

        // === SUB-DEPARTEMENT: row 0=header, 1+=data. Col: B(1)=code, C(2)=name, H(7)=note ===
        case 'SUB-DEPARTEMENT':
            $c = 0;
            for ($i = 1; $i < count($rows); $i++) {
                $r = $rows[$i];
                if (ins($pdo, 'sub_department', [
                    'code' => $r[1] ?? '',
                    'name' => $r[2] ?? '',
                    'note' => $r[7] ?? '',
                ])) $c++;
            }
            echo "'$sName' -> $c inserted\n";
            break;

        // === EMPLOYEES: this sheet is column definitions, not data ===
        case 'EMPLOYEES':
            echo "'$sName' -> skipped (column definitions only)\n";
            break;

        // === EMAIL: row 0=header, 1+=data. A=email, B=nip, C=domain, D=func, E=type, F=license, G=mfa ===
        case 'EMAIL':
            $c = 0;
            for ($i = 1; $i < count($rows); $i++) {
                $r = $rows[$i];
                $st = (!empty($r[7]) && $r[7] === 'ACTIVED') ? 'ACTIVED' : 'DEACTIVED';
                if (ins($pdo, 'email', [
                    'email' => $r[1] ?? '',
                    'nip' => $r[2] ?? '',
                    'domain' => $r[3] ?? '',
                    'type' => ($r[4] ?? '') ?: 'USER',
                    'apps' => $r[5] ?? 'Microsoft Office 365',
                    'layer' => ($r[6] ?? '') ?: 'STANDARD',
                    'status' => $st,
                ])) {
                    $c++;
                    if (!empty($r[2])) $employeeNips[] = $r[2];
                }
            }
            echo "'$sName' -> $c inserted\n";
            break;

        // === AD: row 0=header, 1+=data. A=mail, D=pic_nip, E=wst_access, F=net_access, G=svr_access ===
        case 'AD':
            $c = 0;
            for ($i = 1; $i < count($rows); $i++) {
                $r = $rows[$i];
                if (ins($pdo, 'ad', [
                    'username' => $r[1] ?? '',
                    'pic_nip' => $r[4] ?? '',
                    'wst_access' => $r[5] ?? '',
                    'net_access' => $r[6] ?? '',
                    'svr_access' => $r[7] ?? '',
                ])) {
                    $c++;
                    if (!empty($r[4])) $employeeNips[] = $r[4];
                }
            }
            echo "'$sName' -> $c inserted\n";
            break;

        // === WORKSTATION: row2=units, row3=header, 4+=data. Uses dynamic column mapping ===
        case 'WORKSTATION':
            if ($wsSchemaCols === null) $wsSchemaCols = getWsColumns($pdo);
            $headerRow = $rows[2] ?? []; // row index 2 = 3rd row (0-based in parsed array)
            $colMap = [];
            foreach ($headerRow as $colIdx => $colName) {
                $colMap[$colIdx] = strtolower($colName);
            }
            // Also exclude helper columns
            $excludeCols = ['query', 'column1', 'val-1', 'bc'];
            $c = 0;
            for ($i = 3; $i < count($rows); $i++) {
                $r = $rows[$i];
                $data = [];
                foreach ($colMap as $colIdx => $dbCol) {
                    if (in_array($dbCol, $excludeCols)) continue;
                    if (!in_array($dbCol, $wsSchemaCols)) continue;
                    $val = $r[$colIdx] ?? '';
                    if ($val !== '' && $val !== null) {
                        $data[$dbCol] = $val;
                    }
                }
                if (!empty($data) && ins($pdo, 'workstation', $data)) {
                    $c++;
                    if (!empty($data['pic_nip'])) $employeeNips[] = $data['pic_nip'];
                }
            }
            echo "'$sName' -> $c inserted\n";
            break;

        // === Q-WS: row 0=header, 1+=data. A=column_name, B=data_type, C(+D)=length_info ===
        case 'Q-WS':
            $c = 0;
            for ($i = 1; $i < count($rows); $i++) {
                $r = $rows[$i];
                $lenInfo = ($r[3] ?? '');
                if ($lenInfo && ($r[4] ?? '')) $lenInfo .= ', ' . $r[4];
                elseif (!$lenInfo) $lenInfo = $r[4] ?? '';
                if (ins($pdo, 'q_ws', [
                    'column_name' => $r[1] ?? '',
                    'data_type' => $r[2] ?? '',
                    'length_info' => $lenInfo,
                ])) $c++;
            }
            echo "'$sName' -> $c inserted\n";
            break;

        // === ME: row 0=header, 1+=data. A=id, B=name, C=time_desc, D=characteristic ===
        case 'ME':
            $c = 0;
            for ($i = 1; $i < count($rows); $i++) {
                $r = $rows[$i];
                if (ins($pdo, 'me', [
                    'id_maintenance' => $r[1] ?? '',
                    'maintenance' => $r[2] ?? '',
                    'time_desc' => $r[3] ?? '',
                    'characteristic' => $r[4] ?? '',
                ])) $c++;
            }
            echo "'$sName' -> $c inserted\n";
            break;

        // === TASK: row 1=header, 2+=data. A=id_task, B=id_maintenance, C=maintenance, D=schedule, E=sch_conv ===
        case 'TASK':
            $c = 0;
            for ($i = 2; $i < count($rows); $i++) {
                $r = $rows[$i];
                $sch = $r[5] ?? '';
                if (is_numeric($sch)) $sch = date('Y-m-d', ($sch - 25569) * 86400);
                if (ins($pdo, 'task', [
                    'id_task' => $r[1] ?? '',
                    'id_maintenance' => $r[2] ?? '',
                    'maintenance' => $r[3] ?? '',
                    'schedule_task' => $r[4] ?? 0,
                    'sch_conv' => $sch,
                ])) $c++;
            }
            echo "'$sName' -> $c inserted\n";
            break;

        // === WH: row 1=header, 2+=data. A=id_wh, B=no, C=id_asset, D=wh_site, E=status, F=status_available ===
        case 'WH':
            $c = 0;
            for ($i = 2; $i < count($rows); $i++) {
                $r = $rows[$i];
                if (ins($pdo, 'wh', [
                    'id_wh' => $r[1] ?? '',
                    'no' => $r[2] ?? '',
                    'id_asset' => $r[3] ?? '',
                    'wh_site' => $r[4] ?? '',
                    'status' => $r[5] ?? '',
                    'status_available' => $r[6] ?? 0,
                ])) $c++;
            }
            echo "'$sName' -> $c inserted\n";
            break;

        // === AM: row 1=header, 2+=data. A=barcode, B=code_item, C=owner_code, D=id_site,
        //    E=no_pr, F=no_po, G=date_pr, L=date_shipping, N=recipient, O=price, P=qty, Q=date_acq, S=coll_support ===
        case 'AM':
            $c = 0;
            for ($i = 2; $i < count($rows); $i++) {
                $r = $rows[$i];
                $dp = $r[7] ?? '';
                $ds = $r[12] ?? '';
                $da = $r[17] ?? '';
                foreach ([&$dp, &$ds, &$da] as &$d) {
                    if (is_numeric($d)) $d = date('Y-m-d', ($d - 25569) * 86400);
                    elseif (preg_match('#^\d{2}/\d{2}/\d{4}$#', $d)) {
                        $dt = DateTime::createFromFormat('d/m/Y', $d);
                        $d = $dt ? $dt->format('Y-m-d') : $d;
                    }
                }
                unset($d);
                if (ins($pdo, 'am', [
                    'barcode' => $r[1] ?? '',
                    'code_item' => $r[2] ?? '',
                    'owner_code' => $r[3] ?? '',
                    'id_site' => $r[4] ?? '',
                    'no_pr' => $r[5] ?? '',
                    'no_po' => $r[6] ?? '',
                    'date_pr' => $dp,
                    'date_shipping' => $ds,
                    'recipient' => $r[14] ?? '',
                    'price' => str_replace(',', '.', $r[15] ?? '0'),
                    'qty' => $r[16] ?? 1,
                    'date_acquisition' => $da,
                    'coll_support' => $r[19] ?? '',
                ])) $c++;
            }
            echo "'$sName' -> $c inserted\n";
            break;

        default:
            echo "'$sName' -> skipped (no handler)\n";
    }
}

// ============================================================
// Auto-generate employee records from collected NIPs
// ============================================================
$employeeNips = array_unique(array_filter($employeeNips));
echo "\nAuto-generating " . count($employeeNips) . " employees...\n";
$c = 0;
foreach ($employeeNips as $nip) {
    if (ins($pdo, 'employee', ['nip' => $nip, 'name' => "Employee $nip"])) $c++;
}
echo "Employees inserted: $c\n";

$pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

// ============================================================
// Summary
// ============================================================
echo "\nSummary:\n";
$tables = ['level','directorate','division','department','sub_department','business_unit','corp','item','site','employee','email','ad','workstation','q_ws','me','task','wh','am'];
foreach ($tables as $t) {
    $cnt = $pdo->query("SELECT COUNT(*) FROM `$t`")->fetchColumn();
    echo "  $t: $cnt\n";
}

$zip->close();
echo "\nDone.\n";
