Add-Type -AssemblyName System.IO.Compression.FileSystem
$zip = [System.IO.Compression.ZipFile]::OpenRead("C:\Users\matti\Documents\Trabajos_Gente\selitec\tema-selitec.zip")
$count = 0
foreach ($entry in $zip.Entries) {
    if ($count -lt 15) {
        Write-Output "[$($entry.FullName)] (len=$($entry.Length), compressed=$($entry.CompressedLength))"
    }
    $count++
}
Write-Output "--- Total entries: $count ---"
$zip.Dispose()
