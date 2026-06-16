<?php
$zip = new ZipArchive;
$zip->open(__DIR__ . '/structure_data.xlsx');

$sharedStrings = [];
if (($idx = $zip->locateName('xl/sharedStrings.xml')) !== false) {
    $xml = simplexml_load_string($zip->getFromIndex($idx));
    foreach ($xml->si as $si) $sharedStrings[] = (string)$si->t;
}

$wb = simplexml_load_string($zip->getFromName('xl/workbook.xml'));
$sheets = [];
$i = 1;
foreach ($wb->sheets->sheet as $s) {
    $a = $s->attributes();
    $sheets[(string)$a['name']] = $i++;
}

$targets = ['EMPLOYEES','LEVEL','DIRECTORATE','DIVISION','DEPARTEMENT','SUB-DEPARTEMENT','BUSINESS-UNIT','CORP'];
foreach ($targets as $name) {
    $num = $sheets[$name] ?? 0;
    echo "$name: sheet index $num\n";
    if ($num > 0) {
        $xml = simplexml_load_string($zip->getFromName("xl/worksheets/sheet{$num}.xml"));
        $rows = $xml->sheetData->row;
        echo "  Rows: " . count($rows) . "\n";
        foreach ($rows as $row) {
            $vals = [];
            foreach ($row->c as $cell) {
                $ref = (string)$cell['r'];
                $type = (string)$cell['t'];
                $v = (string)$cell->v;
                if ($v === '') continue;
                $value = ($type === 's') ? ($sharedStrings[(int)$v] ?? $v) : $v;
                $vals[] = $value;
            }
            if (!empty($vals)) echo '  ' . implode(' | ', $vals) . "\n";
        }
    }
}
$zip->close();
