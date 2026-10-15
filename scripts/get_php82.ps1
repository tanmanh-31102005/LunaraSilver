$ErrorActionPreference = 'Stop'
$projectRoot = Split-Path -Parent $PSScriptRoot
$targetDir = Join-Path $projectRoot 'php82'

Write-Host "========================================================" -ForegroundColor Cyan
Write-Host "   TAI VA CAI DAT PHP 8.2 PORTABLE CHO DU AN LUNARA    " -ForegroundColor Cyan
Write-Host "========================================================" -ForegroundColor Cyan
Write-Host ""

if (Test-Path (Join-Path $targetDir 'php.exe')) {
    Write-Host "[+] PHP 8.2 Portable da ton tai tai: $targetDir" -ForegroundColor Green
    
    # Loai bo extension=bcmath trong php.ini neu co vi bcmath da build san trong loi PHP tren Windows
    $iniFile = Join-Path $targetDir "php.ini"
    if (Test-Path $iniFile) {
        $content = Get-Content $iniFile -Raw
        $content = $content -replace '(?m)^extension=bcmath\r?\n?', ';extension=bcmath' + [Environment]::NewLine
        Set-Content -Path $iniFile -Value $content -NoNewline
    }
    
    & (Join-Path $targetDir 'php.exe') -v
    exit 0
}

$zipUrl = "https://windows.php.net/downloads/releases/php-8.2.34-Win32-vs16-x64.zip"
$tempZip = Join-Path $projectRoot "php-8.2-temp.zip"

Write-Host "[*] Dang tai PHP 8.2.34 Portable (khoang 32 MB) tu windows.php.net..." -ForegroundColor Yellow
[Net.ServicePointManager]::SecurityProtocol = [Net.SecurityProtocolType]::Tls12

try {
    Invoke-WebRequest -Uri $zipUrl -OutFile $tempZip -UseBasicParsing
    Write-Host "[+] Tai xuong thanh cong!" -ForegroundColor Green
} catch {
    Write-Host "[!] Thu muc tiep theo: Link luu tru (archive)..." -ForegroundColor Yellow
    $archiveUrl = "https://windows.php.net/downloads/releases/archives/php-8.2.27-Win32-vs16-x64.zip"
    Invoke-WebRequest -Uri $archiveUrl -OutFile $tempZip -UseBasicParsing
}

Write-Host "[*] Dang giai nen vao thu muc: php82..." -ForegroundColor Yellow
if (-not (Test-Path $targetDir)) {
    New-Item -ItemType Directory -Path $targetDir -Force | Out-Null
}
Expand-Archive -Path $tempZip -DestinationPath $targetDir -Force
Remove-Item -Path $tempZip -Force -ErrorAction SilentlyContinue

Write-Host "[*] Dang cau hinh php.ini voi cac extension bat buoc..." -ForegroundColor Yellow
$iniDevelopment = Join-Path $targetDir "php.ini-development"
$iniFile = Join-Path $targetDir "php.ini"

if (Test-Path $iniDevelopment) {
    Copy-Item $iniDevelopment $iniFile -Force
} else {
    New-Item -ItemType File -Path $iniFile -Force | Out-Null
}

$iniContent = Get-Content $iniFile -Raw
$iniContent = $iniContent -replace ';extension_dir = "ext"', 'extension_dir = "ext"'
# Chu y: bcmath da duoc build san trong core PHP Windows, khong khai bao o ext
$extensions = @('curl', 'fileinfo', 'gd', 'mbstring', 'mysqli', 'openssl', 'pdo_mysql', 'zip')
foreach ($ext in $extensions) {
    $iniContent = $iniContent -replace ";extension=$ext", "extension=$ext"
}

$extraConfig = @"

; Lunara Silver Required Extensions
extension_dir = "ext"
extension=curl
extension=fileinfo
extension=gd
extension=mbstring
extension=mysqli
extension=openssl
extension=pdo_mysql
extension=zip
memory_limit = 512M
max_execution_time = 300
"@

Add-Content -Path $iniFile -Value $extraConfig

Write-Host "[+] Da cau hinh php.ini thanh cong!" -ForegroundColor Green
Write-Host "[+] Kiem tra phien ban PHP 8.2 vua cai dat:" -ForegroundColor Green
Write-Host ""
& (Join-Path $targetDir 'php.exe') -v
Write-Host ""
