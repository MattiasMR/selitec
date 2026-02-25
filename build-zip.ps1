$ErrorActionPreference = "Stop"
Add-Type -AssemblyName System.IO.Compression
Add-Type -AssemblyName System.IO.Compression.FileSystem

$sourceDir = "C:\Users\matti\Documents\Trabajos_Gente\selitec\wp-content\themes\tema-selitec"
$zipPath   = "C:\Users\matti\Documents\Trabajos_Gente\selitec\tema-selitec.zip"

if (Test-Path $zipPath) { Remove-Item $zipPath -Force }

# Create ZIP manually so we can force forward slashes in every entry
$zip = [System.IO.Compression.ZipFile]::Open($zipPath, [System.IO.Compression.ZipArchiveMode]::Create)

$files = Get-ChildItem -Path $sourceDir -Recurse -File
foreach ($file in $files) {
    # Build relative path with forward slashes inside tema-selitec/
    $relative = $file.FullName.Substring($sourceDir.Length + 1).Replace('\', '/')
    $entryName = "tema-selitec/" + $relative
    [System.IO.Compression.ZipFileExtensions]::CreateEntryFromFile($zip, $file.FullName, $entryName) | Out-Null
}

$zip.Dispose()

$size = [math]::Round((Get-Item $zipPath).Length / 1KB)
Write-Output "Built $zipPath (${size} KB)"
