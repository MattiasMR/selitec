Add-Type -AssemblyName System.IO.Compression.FileSystem
$zip = [System.IO.Compression.ZipFile]::OpenRead("C:\Users\matti\Documents\Trabajos_Gente\selitec\tema-selitec.zip")
foreach ($entry in $zip.Entries) {
    if ($entry.Name -eq "style.css") {
        $bytes = [System.Text.Encoding]::UTF8.GetBytes($entry.FullName)
        $hex = ($bytes | ForEach-Object { "0x{0:X2}({1})" -f $_, [char]$_ }) -join " "
        Write-Output "FullName raw bytes: $hex"
        Write-Output "FullName string: $($entry.FullName)"
        break
    }
}
$zip.Dispose()
