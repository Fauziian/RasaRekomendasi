<?php
function docx_to_text($filename) {
    $zip = new ZipArchive;
    if ($zip->open($filename) === TRUE) {
        $xml = $zip->getFromName('word/document.xml');
        $zip->close();
        if ($xml) {
            // Replace word XML tags with spaces/newlines to keep some structure
            $xml = str_replace(['<w:p>', '<w:p ', '</w:p>'], ["\n", "\n", "\n"], $xml);
            $xml = str_replace(['<w:tab/>', '<w:tab'], ["\t", "\t"], $xml);
            $xml = str_replace(['<w:br/>', '<w:br'], ["\n", "\n"], $xml);
            $text = strip_tags($xml);
            // Decode html entities
            $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
            return $text;
        }
    }
    return "Failed to open docx: " . $filename;
}

$srs_path = 'c:/xampp/htdocs/P3L/RasaRekomendasi/docs/SRS Sistem Rekomendasi resep makanan.docx';
$sdd_path = 'c:/xampp/htdocs/P3L/RasaRekomendasi/docs/SDD REKOMENDASI RESEP MAKANAN.docx';

file_put_contents('c:/xampp/htdocs/P3L/RasaRekomendasi/docs/srs_extracted.txt', docx_to_text($srs_path));
file_put_contents('c:/xampp/htdocs/P3L/RasaRekomendasi/docs/sdd_extracted.txt', docx_to_text($sdd_path));

echo "Extraction finished!";
