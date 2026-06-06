function Extract-DocxText($docxPath, $outputPath) {
    $tempDir = Join-Path $env:TEMP ([Guid]::NewGuid().Guid)
    New-Item -ItemType Directory -Path $tempDir | Out-Null
    
    $zipPath = Join-Path $tempDir "temp.zip"
    Copy-Item $docxPath $zipPath
    
    Expand-Archive -Path $zipPath -DestinationPath $tempDir -Force
    
    $xmlPath = Join-Path $tempDir "word/document.xml"
    if (Test-Path $xmlPath) {
        $xml = [xml](Get-Content $xmlPath -Raw -Encoding UTF8)
        # XML namespace manager
        $ns = New-Object System.Xml.XmlNamespaceManager($xml.NameTable)
        $ns.AddNamespace("w", "http://schemas.openxmlformats.org/wordprocessingml/2006/main")
        
        # Select all paragraphs
        $paragraphs = $xml.SelectNodes("//w:p", $ns)
        $textLines = New-Object System.Collections.Generic.List[string]
        
        foreach ($p in $paragraphs) {
            $runs = $p.SelectNodes(".//w:t", $ns)
            $pText = ""
            foreach ($r in $runs) {
                $pText += $r.InnerText
            }
            if ($pText.Trim().Length -gt 0) {
                $textLines.Add($pText)
            }
        }
        
        $textLines | Out-File -FilePath $outputPath -Encoding utf8
    } else {
        Write-Error "Could not find word/document.xml in $docxPath"
    }
    
    Remove-Item -Path $tempDir -Recurse -Force
}

Extract-DocxText "c:/xampp/htdocs/P3L/RasaRekomendasi/docs/SRS Sistem Rekomendasi resep makanan.docx" "c:/xampp/htdocs/P3L/RasaRekomendasi/docs/srs_extracted.txt"
Extract-DocxText "c:/xampp/htdocs/P3L/RasaRekomendasi/docs/SDD REKOMENDASI RESEP MAKANAN.docx" "c:/xampp/htdocs/P3L/RasaRekomendasi/docs/sdd_extracted.txt"

Write-Host "Extraction completed successfully!"
