Add-Type -AssemblyName System.IO.Compression.FileSystem
$zip = [System.IO.Compression.ZipFile]::OpenRead("C:\Users\matti\Documents\Trabajos_Gente\selitec\tema-selitec.zip")
foreach ($entry in $zip.Entries) {
    if ($entry.Name -match "\.(php|css)$" -or $entry.FullName -match "^[^/]+/$") {
        Write-Output "$($entry.FullName) ($($entry.Length) bytes)"
    }
}
$zip.Dispose()
