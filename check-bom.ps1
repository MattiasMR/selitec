$path = "C:\Users\matti\Documents\Trabajos_Gente\selitec\wp-content\themes\tema-selitec\includes\event-metaboxes.php"
$stream = [System.IO.File]::OpenRead($path)
$buffer = New-Object byte[] 10
$read = $stream.Read($buffer, 0, 10)
$stream.Close()
$hex = ($buffer[0..($read-1)] | ForEach-Object { "0x{0:X2}" -f $_ }) -join " "
Write-Output "First $read bytes: $hex"
if ($buffer[0] -eq 0xEF -and $buffer[1] -eq 0xBB -and $buffer[2] -eq 0xBF) {
    Write-Output "BOM DETECTED!"
} else {
    Write-Output "No BOM"
}
