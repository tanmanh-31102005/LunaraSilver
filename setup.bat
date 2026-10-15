@echo off
setlocal EnableDelayedExpansion
title LUNARA SILVER - SETUP
cls

echo ========================================================
echo        LUNARA SILVER - CAI DAT DU AN TU DONG
echo ========================================================
echo.

REM Tu dong sua file php.ini cua ban portable neu co cau hinh bcmath loi
if exist "%~dp0php82\php.ini" (
    powershell -NoProfile -Command "$f='%~dp0php82\php.ini'; if(Test-Path $f){ $c=(Get-Content $f -Raw) -replace '(?m)^extension=bcmath\r?\n?', ';extension=bcmath`r`n'; Set-Content -Path $f -Value $c -NoNewline }" >nul 2>nul
)

REM 0. Kiem tra xem da co san PHP 8.2 Portable trong thu muc du an chua
if exist "%~dp0php82\php.exe" (
    set "PHP_CMD=%~dp0php82\php.exe"
    echo [+] Da tim thay PHP 8.2 Portable trong du an.
    goto :check_php_version
)

REM 1. Tim duong dan PHP tren he thong
set "PHP_CMD="

where php >nul 2>nul
if %errorlevel% equ 0 (
    set "PHP_CMD=php"
    echo [+] Tim thay PHP trong bien moi truong PATH.
    goto :check_php_version
)

if exist "C:\xampp\php\php.exe" (
    set "PHP_CMD=C:\xampp\php\php.exe"
    echo [+] Tim thay PHP tai C:\xampp\php\php.exe
    goto :check_php_version
)

if exist "D:\xampp\php\php.exe" (
    set "PHP_CMD=D:\xampp\php\php.exe"
    echo [+] Tim thay PHP tai D:\xampp\php\php.exe
    goto :check_php_version
)

if exist "E:\xampp\php\php.exe" (
    set "PHP_CMD=E:\xampp\php\php.exe"
    echo [+] Tim thay PHP tai E:\xampp\php\php.exe
    goto :check_php_version
)

for /d %%D in ("C:\laragon\bin\php\php-*") do (
    if exist "%%D\php.exe" (
        set "PHP_CMD=%%D\php.exe"
        echo [+] Tim thay PHP tai %%D\php.exe
        goto :check_php_version
    )
)
for /d %%D in ("D:\laragon\bin\php\php-*") do (
    if exist "%%D\php.exe" (
        set "PHP_CMD=%%D\php.exe"
        echo [+] Tim thay PHP tai %%D\php.exe
        goto :check_php_version
    )
)

:php_not_found
echo [!] KHONG TIM THAY PHP TREN HE THONG!
echo.
echo Ban co muon TU DONG TAI PHP 8.2 Portable khoang 32MB ve du an khong?
set /p "DL_CHOICE=Nhan Y de tai, N de nhap duong dan thu cong [Y/N]: "
if /i "!DL_CHOICE!"=="Y" (
    powershell -NoProfile -ExecutionPolicy Bypass -File "%~dp0scripts\get_php82.ps1"
    if exist "%~dp0php82\php.exe" (
        set "PHP_CMD=%~dp0php82\php.exe"
        goto :continue_setup
    )
)

echo.
echo Vui long nhap duong dan den file php.exe tren may ban:
echo Vi du: C:\xampp\php\php.exe hoac D:\xampp\php\php.exe
set /p "USER_PHP=Duong dan PHP: "
if exist "%USER_PHP%" (
    set "PHP_CMD=%USER_PHP%"
    goto :check_php_version
) else (
    echo [ERROR] Duong dan khong hop le hoac khong ton tai file php.exe!
    pause
    exit /b 1
)

:check_php_version
echo.
echo [*] Kiem tra phien ban PHP...
"%PHP_CMD%" -v
echo.

set "PHP_ID=0"
"%PHP_CMD%" -n -r "echo PHP_VERSION_ID;" > "%TEMP%\lunara_ver.tmp" 2>nul
if exist "%TEMP%\lunara_ver.tmp" (
    set /p PHP_ID=<"%TEMP%\lunara_ver.tmp"
    del "%TEMP%\lunara_ver.tmp" >nul 2>nul
)

if !PHP_ID! lss 80200 (
    echo ========================================================
    echo [!] CANH BAO: PHIEN BAN PHP KHONG TUONG THICH!
    echo ========================================================
    echo Du an Laravel 12 yeu cau PHP 8.2.0 tro len.
    echo May ban dang su dung PHP cu - phien ban ID: !PHP_ID!
    echo.
    echo GIAI PHAP: He thong co the TU DONG TAI PHP 8.2 Portable
    echo ve thu muc du an de chay ngay, khong can go hoac cai lai XAMPP!
    echo ========================================================
    echo.
    set /p "AUTO_DL=Ban co muon tu dong tai PHP 8.2 ngay bay gio khong [Y/N]: "
    if /i "!AUTO_DL!"=="Y" (
        echo.
        echo [*] Dang tai va giai nen PHP 8.2 Portable...
        powershell -NoProfile -ExecutionPolicy Bypass -File "%~dp0scripts\get_php82.ps1"
        if exist "%~dp0php82\php.exe" (
            set "PHP_CMD=%~dp0php82\php.exe"
            echo [+] Da chuyen sang dung PHP 8.2 Portable thanh cong!
            goto :continue_setup
        ) else (
            echo [ERROR] Tai PHP 8.2 that bai! Vui long kiem tra ket noi Internet.
            pause
            exit /b 1
        )
    ) else (
        echo.
        echo [!] Ban can nang cap XAMPP len ban ho tro PHP 8.2 hoac chay file get_php82.bat
        pause
        exit /b 1
    )
)

:continue_setup
echo [+] Phien ban PHP hop le de khoi chay Laravel 12.
echo.

REM Dam bao cac thu muc luu tru storage bat buoc ton tai
if not exist "storage\framework\views" mkdir "storage\framework\views" >nul 2>nul
if not exist "storage\framework\cache\data" mkdir "storage\framework\cache\data" >nul 2>nul
if not exist "storage\framework\sessions" mkdir "storage\framework\sessions" >nul 2>nul
if not exist "storage\logs" mkdir "storage\logs" >nul 2>nul
if not exist "bootstrap\cache" mkdir "bootstrap\cache" >nul 2>nul

REM 2. Tao file .env neu chua co
if not exist ".env" (
    echo [*] Dang tao file .env tu .env.example...
    copy .env.example .env >nul
    echo [+] Da tao file .env thanh cong!
) else (
    echo [+] File .env da ton tai.
)

REM 3. Tao APP_KEY
echo [*] Dang khoi tao Application Key...
"%PHP_CMD%" artisan key:generate --force

REM 4. Tao Storage Link
echo [*] Dang tao Storage Link...
"%PHP_CMD%" artisan storage:link

REM 5. Don dep cache
echo [*] Dang lam sach cache...
"%PHP_CMD%" artisan config:clear
"%PHP_CMD%" artisan view:clear
"%PHP_CMD%" artisan route:clear

echo.
echo ========================================================
echo        KHOI TAO CO SO DU LIEU (DATABASE)
echo ========================================================
echo.
echo Ban co muon he thong TU DONG tao bang va nap 45 san pham mau khong?
echo (Yeu cau: Da bat MySQL trong XAMPP/Laragon va tao CSDL: lunara_silver)
set /p "MIGRATE_CHOICE=Tu dong khoi tao CSDL [Y/N]: "
if /i "!MIGRATE_CHOICE!"=="Y" (
    echo [*] Dang chay migration va seeder...
    "%PHP_CMD%" artisan migrate:fresh --seed --force
    if !errorlevel! equ 0 (
        echo [+] Khoi tao CSDL thanh cong!
    ) else (
        echo [!] Khong the ket noi MySQL hoac CSDL chua ton tai.
        echo Ban co the import file lunara_silver.sql qua phpMyAdmin.
    )
)

echo.
echo ========================================================
echo             THIET LAP DU AN HOAN TAT!
echo ========================================================
echo.
echo Bay gio ban chi can nhap dup chuot vao file [start.bat]
echo de khoi chay may chu va mo website ngay lap tuc!
echo ========================================================
pause
