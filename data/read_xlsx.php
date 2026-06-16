<?php
$path = __DIR__ . '/structure_data.xlsx';
$zip = new ZipArchive;
if ($zip->open($path) !== TRUE) { die("Failed to open xlsx\n"); }

$sharedStrings = [];
if (($index = $zip->locateName('xl/sharedStrings.xml')) !== false) {
    $xml = simplexml_load_string($zip->getFromIndex($index));
    foreach ($xml->si as $si) { $sharedStrings[] = (string)$si->t; }
}

$wbXml = simplexml_load_string($zip->getFromName('xl/workbook.xml'));
$sheetNames = [];
foreach ($wbXml->sheets->sheet as $sheet) {
    $attrs = $sheet->attributes();
    $sheetNames[] = (string)$attrs['name'];
}

echo "Total sheets: " . count($sheetNames) . "\n";
echo "Names: " . implode(', ', $sheetNames) . "\n";

foreach ($sheetNames as $idx => $sName) {
    $sNum = $idx + 1;
    $content = $zip->getFromName("xl/worksheets/sheet{$sNum}.xml");
    if (!$content) { echo "\n=== $sName (EMPTY) ===\n"; continue; }
    $sXml = simplexml_load_string($content);
    $rows = $sXml->sheetData->row;
    echo "\n=== $sName (" . count($rows) . " rows) ===\n";
    foreach ($rows as $row) {
        $vals = [];
        foreach ($row->c as $cell) {
            $ref = (string)$cell['r'];
            $type = (string)$cell['t'];
            $v = (string)$cell->v;
            if ($v === '') continue;
            $value = ($type === 's') ? ($sharedStrings[(int)$v] ?? $v) : $v;
            $vals[] = "$ref=$value";
        }
        if (!empty($vals)) echo "  " . implode(', ', $vals) . "\n";
    }
}
$zip->close();
