<?php

class SimpleXLSX
{
    private $rows = [];
    private $header;

    public function setHeader($header) { $this->header = $header; }
    public function addRow($row) { $this->rows[] = $row; }

    public function output($filename)
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->startDocument('1.0', 'UTF-8', 'yes');
        $xml->setIndent(true);

        // [Content_Types].xml
        $contentTypes = new XMLWriter();
        $contentTypes->openMemory();
        $contentTypes->startDocument('1.0', 'UTF-8', 'yes');
        $contentTypes->startElement('Types');
        $contentTypes->writeAttribute('xmlns', 'http://schemas.openxmlformats.org/package/2006/content-types');
        $contentTypes->writeElement('Default', ['Extension' => 'rels', 'ContentType' => 'application/vnd.openxmlformats-package.relationships+xml']);
        $contentTypes->writeElement('Default', ['Extension' => 'xml', 'ContentType' => 'application/xml']);
        $contentTypes->writeElement('Override', ['PartName' => '/xl/workbook.xml', 'ContentType' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml']);
        $contentTypes->writeElement('Override', ['PartName' => '/xl/worksheets/sheet1.xml', 'ContentType' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml']);
        $contentTypes->writeElement('Override', ['PartName' => '/xl/styles.xml', 'ContentType' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml']);
        $contentTypes->writeElement('Override', ['PartName' => '/xl/sharedStrings.xml', 'ContentType' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sharedStrings+xml']);
        $contentTypes->endElement();
        $contentTypes->endDocument();

        // _rels/.rels
        $rels = new XMLWriter();
        $rels->openMemory();
        $rels->startDocument('1.0', 'UTF-8', 'yes');
        $rels->startElement('Relationships');
        $rels->writeAttribute('xmlns', 'http://schemas.openxmlformats.org/package/2006/relationships');
        $rels->writeElement('Relationship', ['Id' => 'rId1', 'Type' => 'http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument', 'Target' => 'xl/workbook.xml']);
        $rels->endElement();
        $rels->endDocument();

        // xl/workbook.xml
        $wb = new XMLWriter();
        $wb->openMemory();
        $wb->startDocument('1.0', 'UTF-8', 'yes');
        $wb->startElement('workbook');
        $wb->writeAttribute('xmlns', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');
        $wb->writeAttribute('xmlns:r', 'http://schemas.openxmlformats.org/officeDocument/2006/relationships');
        $wb->startElement('sheets');
        $wb->startElement('sheet');
        $wb->writeAttribute('name', 'Sheet1');
        $wb->writeAttribute('sheetId', '1');
        $wb->writeAttribute('r:id', 'rId1');
        $wb->endElement();
        $wb->endElement();
        $wb->endElement();
        $wb->endDocument();

        // xl/_rels/workbook.xml.rels
        $wbr = new XMLWriter();
        $wbr->openMemory();
        $wbr->startDocument('1.0', 'UTF-8', 'yes');
        $wbr->startElement('Relationships');
        $wbr->writeAttribute('xmlns', 'http://schemas.openxmlformats.org/package/2006/relationships');
        $wbr->writeElement('Relationship', ['Id' => 'rId1', 'Type' => 'http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet', 'Target' => 'worksheets/sheet1.xml']);
        $wbr->writeElement('Relationship', ['Id' => 'rId2', 'Type' => 'http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles', 'Target' => 'styles.xml']);
        $wbr->writeElement('Relationship', ['Id' => 'rId3', 'Type' => 'http://schemas.openxmlformats.org/officeDocument/2006/relationships/sharedStrings', 'Target' => 'sharedStrings.xml']);
        $wbr->endElement();
        $wbr->endDocument();

        // xl/styles.xml
        $styles = new XMLWriter();
        $styles->openMemory();
        $styles->startDocument('1.0', 'UTF-8', 'yes');
        $styles->startElement('styleSheet');
        $styles->writeAttribute('xmlns', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');
        $styles->startElement('fonts');
        $styles->writeAttribute('count', '2');
        $styles->startElement('font');
        $styles->writeElement('b');
        $styles->writeElement('sz', ['val' => '11']);
        $styles->writeElement('color', ['rgb' => 'FFFFFFFF']);
        $styles->writeElement('name', ['val' => 'Calibri']);
        $styles->endElement();
        $styles->startElement('font');
        $styles->writeElement('sz', ['val' => '11']);
        $styles->writeElement('name', ['val' => 'Calibri']);
        $styles->endElement();
        $styles->endElement();
        $styles->startElement('fills');
        $styles->writeAttribute('count', '2');
        $styles->writeElement('fill', []);
        $styles->startElement('fill');
        $styles->writeElement('patternFill', ['patternType' => 'solid', 'fgColor' => ['rgb' => 'FF4472C4']]);
        $styles->endElement();
        $styles->endElement();
        $styles->startElement('borders');
        $styles->writeAttribute('count', '1');
        $styles->startElement('border');
        for ($i = 0; $i < 4; $i++) $styles->writeElement('border', ['style' => 'thin']);
        $styles->endElement();
        $styles->endElement();
        $styles->startElement('cellStyleXfs');
        $styles->writeAttribute('count', '1');
        $styles->writeElement('xf', ['numFmtId' => '0', 'fontId' => '0', 'fillId' => '0', 'borderId' => '0']);
        $styles->endElement();
        $styles->startElement('cellXfs');
        $styles->writeAttribute('count', '3');
        $styles->writeElement('xf', ['numFmtId' => '0', 'fontId' => '0', 'fillId' => '0', 'borderId' => '0', 'xfId' => '0']);
        $styles->writeElement('xf', ['numFmtId' => '0', 'fontId' => '0', 'fillId' => '1', 'borderId' => '0', 'xfId' => '0', 'applyFont' => '1', 'applyFill' => '1', 'applyBorder' => '1', 'applyAlignment' => '1', 'alignment' => ['horizontal' => 'center', 'vertical' => 'center', 'wrapText' => '1']]);
        $styles->writeElement('xf', ['numFmtId' => '0', 'fontId' => '1', 'fillId' => '0', 'borderId' => '0', 'xfId' => '0', 'applyBorder' => '1', 'applyAlignment' => '1', 'alignment' => ['vertical' => 'center']]);
        $styles->endElement();
        $styles->endElement();
        $styles->endElement();
        $styles->endDocument();

        // xl/sharedStrings.xml
        $allStrings = [];
        if ($this->header) foreach ($this->header as $h) $allStrings[] = $h;
        foreach ($this->rows as $row) foreach ($row as $cell) $allStrings[] = (string)$cell;
        $allStrings = array_unique($allStrings);
        $stringIndex = array_flip($allStrings);

        $ss = new XMLWriter();
        $ss->openMemory();
        $ss->startDocument('1.0', 'UTF-8', 'yes');
        $ss->startElement('sst');
        $ss->writeAttribute('xmlns', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');
        $ss->writeAttribute('count', count($allStrings));
        $ss->writeAttribute('uniqueCount', count($allStrings));
        foreach ($allStrings as $s) {
            $ss->startElement('si');
            $ss->writeElement('t', $s);
            $ss->endElement();
        }
        $ss->endElement();
        $ss->endDocument();

        // xl/worksheets/sheet1.xml
        $sheet = new XMLWriter();
        $sheet->openMemory();
        $sheet->startDocument('1.0', 'UTF-8', 'yes');
        $sheet->startElement('worksheet');
        $sheet->writeAttribute('xmlns', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');
        $sheet->startElement('sheetData');

        if ($this->header) {
            $sheet->startElement('row');
            $sheet->writeAttribute('r', '1');
            foreach ($this->header as $i => $h) {
                $col = $this->colLetter($i);
                $sheet->startElement('c');
                $sheet->writeAttribute('r', $col . '1');
                $sheet->writeAttribute('t', 's');
                $sheet->writeAttribute('s', '1');
                $sheet->writeElement('v', $stringIndex[$h]);
                $sheet->endElement();
            }
            $sheet->endElement();
        }

        foreach ($this->rows as $r => $row) {
            $rowNum = $r + 2;
            $sheet->startElement('row');
            $sheet->writeAttribute('r', (string)$rowNum);
            foreach ($row as $c => $val) {
                $col = $this->colLetter($c);
                $sheet->startElement('c');
                $sheet->writeAttribute('r', $col . $rowNum);
                $sheet->writeAttribute('s', '2');
                if ($val !== '' && $val !== null) {
                    $sheet->writeAttribute('t', 's');
                    $sheet->writeElement('v', $stringIndex[(string)$val]);
                }
                $sheet->endElement();
            }
            $sheet->endElement();
        }

        $sheet->endElement();
        $sheet->endElement();
        $sheet->endDocument();

        // Build ZIP
        $zip = new ZipArchive();
        $zip->open($filename, ZipArchive::CREATE);
        $zip->addFromString('[Content_Types].xml', $contentTypes->outputMemory());
        $zip->addFromString('_rels/.rels', $rels->outputMemory());
        $zip->addFromString('xl/workbook.xml', $wb->outputMemory());
        $zip->addFromString('xl/_rels/workbook.xml.rels', $wbr->outputMemory());
        $zip->addFromString('xl/styles.xml', $styles->outputMemory());
        $zip->addFromString('xl/sharedStrings.xml', $ss->outputMemory());
        $zip->addFromString('xl/worksheets/sheet1.xml', $sheet->outputMemory());
        $zip->close();
    }

    private function colLetter($i) {
        $letter = '';
        while ($i >= 0) {
            $letter = chr(65 + $i % 26) . $letter;
            $i = intdiv($i, 26) - 1;
        }
        return $letter;
    }
}


class SimplePDF
{
    private $content = '';
    private $pageNum = 0;
    private $fonts = [];

    public function __construct() {
        $this->addFont('Helvetica');
        $this->newPage();
    }

    private function addFont($name) {
        $this->fonts[$name] = ['name' => $name];
    }

    private function newPage() {
        if ($this->pageNum > 0) $this->content .= "0 J\n"; // end page
        $this->pageNum++;
        $this->content .= "q\n";
        $this->content .= "BT /F1 10 Tf 50 750 Td 14 TL\n";
    }

    public function addText($text, $x = 50, $y = null, $size = 10, $bold = false) {
        if ($y === null) {
            // simple sequential text
            $clean = str_replace(['(', ')', '\\'], ['\\(', '\\)', '\\\\'], $text);
            $this->content .= "($clean) Tj\nT*\n";
        } else {
            $clean = str_replace(['(', ')', '\\'], ['\\(', '\\)', '\\\\'], $text);
            $font = $bold ? 'F1' : 'F1';
            $this->content .= "BT /$font $size Tf $x $y Td ($clean) Tj ET\n";
        }
    }

    public function addCell($text, $x, $y, $w, $h, $align = 'L', $bold = false) {
        $clean = str_replace(['(', ')', '\\'], ['\\(', '\\)', '\\\\'], $text);
        $font = $bold ? 'F1' : 'F1';
        $fontSize = $bold ? 10 : 9;

        // Draw cell border
        $this->content .= "$x $y $w $h re S\n";

        // Calculate text position
        $tx = $x + 2;
        $ty = $y + $h - 3;
        if ($align === 'R') $tx = $x + $w - 2 - (strlen($text) * $fontSize * 0.3);
        if ($align === 'C') $tx = $x + ($w / 2) - (strlen($text) * $fontSize * 0.15);

        $this->content .= "BT /$font $fontSize Tf $tx $ty Td ($clean) Tj ET\n";
    }

    public function addTable($header, $rows, $x = 50, $y = 700, $colWidths = [])
    {
        $headers = array_values($header);
        $numCols = count($headers);
        $rowH = 14;
        $tableW = 500;
        $pageH = 750;

        if (empty($colWidths)) {
            $cw = floor($tableW / $numCols);
            $colWidths = array_fill(0, $numCols, $cw);
        }

        $curY = $y;

        // Header row
        foreach ($headers as $i => $h) {
            $cx = $x + array_sum(array_slice($colWidths, 0, $i));
            $this->addCell($h, $cx, $curY - $rowH, $colWidths[$i], $rowH, 'C', true);
        }
        $curY -= $rowH;

        // Data rows
        foreach ($rows as $row) {
            if ($curY - $rowH < 50) {
                $this->newPage();
                $curY = 730;
                foreach ($headers as $i => $h) {
                    $cx = $x + array_sum(array_slice($colWidths, 0, $i));
                    $this->addCell($h, $cx, $curY - $rowH, $colWidths[$i], $rowH, 'C', true);
                }
                $curY -= $rowH;
            }

            $vals = array_values($row);
            foreach ($vals as $i => $v) {
                $cx = $x + array_sum(array_slice($colWidths, 0, $i));
                $this->addCell((string)$v, $cx, $curY - $rowH, $colWidths[$i], $rowH, 'L');
            }
            $curY -= $rowH;
        }
    }

    public function output($filename)
    {
        $this->content .= "Q\n";

        // Split pages by the "q\n" marker from newPage()
        // First "q\n" is the start of page 1 content; subsequent ones start new pages
        $parts = explode("q\n", $this->content);
        $pageContents = [];
        // First element is before any "q\n" (empty string at start), we skip it
        for ($i = 1; $i < count($parts); $i++) {
            $pageContents[] = $parts[$i];
        }
        $numPages = count($pageContents);

        $pdf = "%PDF-1.4\n";
        $objects = [];
        $offsets = [];

        // Obj 1: Catalog
        $objects[] = "<< /Type /Catalog /Pages 2 0 R >>\n";

        // Obj 2: Pages
        $pageObjNumbers = [];
        for ($p = 0; $p < $numPages; $p++) {
            // Content stream obj, then page obj
            $pageObjNumbers[] = 4 + $p * 2 + 1; // page object numbers: 5, 7, 9, ...
        }
        $kids = implode(' ', array_map(function($n) { return "$n 0 R"; }, $pageObjNumbers));
        $objects[] = "<< /Type /Pages /Kids [$kids] /Count $numPages >>\n";

        // Obj 3: Font
        $fontObjNum = 3;
        $objects[] = "<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica /Encoding /WinAnsiEncoding >>\n";

        // Pages and their content streams
        for ($p = 0; $p < $numPages; $p++) {
            $pageContent = $pageContents[$p];
            $contentLen = strlen($pageContent);

            // Content stream object
            $contentObjNum = 4 + $p * 2;
            $objects[] = "<< /Length $contentLen >>\nstream\n$pageContent\nendstream\n";

            // Page object
            $pageObjNum = $contentObjNum + 1;
            $objects[] = "<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents $contentObjNum 0 R /Resources << /Font << /F1 $fontObjNum 0 R >> >> >>\n";
        }

        // Build PDF
        $offset = strlen($pdf);
        foreach ($objects as $i => $obj) {
            $offsets[] = $offset;
            $objNum = $i + 1;
            $pdf .= "$objNum 0 obj\n$obj";
            $pdf .= "endobj\n";
            $offset = strlen($pdf);
        }

        $xrefOffset = strlen($pdf);
        $pdf .= "xref\n0 " . (count($objects) + 1) . "\n0000000000 65535 f \n";
        foreach ($offsets as $o) {
            $pdf .= sprintf("%010d 00000 n \n", $o);
        }

        $pdf .= "trailer\n<< /Size " . (count($objects) + 1) . " /Root 1 0 R >>\n";
        $pdf .= "startxref\n$xrefOffset\n%%EOF\n";

        file_put_contents($filename, $pdf);
    }
}
