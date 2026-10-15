@echo off
setlocal EnableDelayedExpansion
title LUNARA SILVER - MAY CHU WEB
cls

echo ========================================================
echo          LUNARA SILVER - KHOI CHAY MAY CHU
echo ========================================================
echo.

REM 1. Luon xoa file public\hot neu co de website luon nap CSS/JS da build san trong public\build
if exist "public\hot" del "public\hot" >nul 2>nul

REM 2. Tu dong sua file php.ini cua ban portable neu co cau hinh bcmath loi
if exist "%~dp0php82\php.ini" (
    powershell -NoProfile -Command "$f='%~dp0php82\php.ini'; if(Test-Path $f){ $c=(Get-Content $f -Raw) -replace '(?m)^extension=bcmath\r?\n?', ';extension=bcmath`r`n'; Set-Content -Path $f -Value $c -NoNewline }" >nul 2>nul
)

REM 3. Dam bao cac thu muc luu tru storage bat buoc ton tai
if not exist "storage\framework\views" mkdir "storage\framework\views" >nul 2>nul
if not exist "storage\framework\cache\data" mkdir "storage\framework\cache\data" >nul 2>nul
if not exist "storage\framework\sessions" mkdir "storage\framework\sessions" >nul 2>nul
if not exist "storage\logs" mkdir "storage\logs" >nul 2>nul
if not exist "bootstrap\cache" mkdir "bootstrap\cache" >nul 2>nul

REM 4. Kiem tra xem co PHP 8.2 Portable trong du an khong
if exist "%~dp0php82\php.exe" (
    set "PHP_CMD=%~dp0php82\php.exe"
    goto :check_php_version
)

REM 5. Tim duong dan PHP tren he thong
set "PHP_CMD="

where php >nul 2>nul
if %errorlevel% equ 0 (
    set "PHP_CMD=php"
    goto :check_php_version
)

if exist "C:\xampp\php\php.exe" (
    set "PHP_CMD=C:\xampp\php\php.exe"
    goto :check_php_version
)

if exist "D:\xampp\php\php.exe" (
    set "PHP_CMD=D:\xampp\php\php.exe"
    goto :check_php_version
)

if exist "E:\xampp\php\php.exe" (
    set "PHP_CMD=E:\xampp\php\php.exe"
    goto :check_php_version
)

for /d %%D in ("C:\laragon\bin\php\php-*") do (
    if exist "%%D\php.exe" (
        set "PHP_CMD=%%D\php.exe"
        goto :check_php_version
    )
)
for /d %%D in ("D:\laragon\bin\php\php-*") do (
    if exist "%%D\php.exe" (
        set "PHP_CMD=%%D\php.exe"
        goto :check_php_version
    )
)

:php_not_found
echo [!] KHONG TIM THAY PHP HOAC PHIEN BAN KHONG PHU HOP!
echo Vui long chay file [get_php82.bat] de tu dong cai dat PHP 8.2 Portable ve du an.
pause
exit /b 1

:check_php_version
set "PHP_ID=0"
"%PHP_CMD%" -n -r "echo PHP_VERSION_ID;" > "%TEMP%\lunara_ver_start.tmp" 2>nul
if exist "%TEMP%\lunara_ver_start.tmp" (
    set /p PHP_ID=<"%TEMP%\lunara_ver_start.tmp"
    del "%TEMP%\lunara_ver_start.tmp" >nul 2>nul
)

if !PHP_ID! lss 80200 (
    echo ========================================================
    echo [!] CANH BAO: PHP tren may cua ban dang duoi 8.2!
    echo ========================================================
    echo Vui long chay file [get_php82.bat] hoac [setup.bat]
    echo de he thong tu dong tai PHP 8.2 Portable ve su dung!
    echo ========================================================
    pause
    exit /b 1
)

REM 6. Kiem tra .env
if not exist ".env" (
    echo [!] Chua co file .env! Dang tu dong chay setup.bat...
    call setup.bat
)

REM 7. Tu dong cap nhat cau truc Database neu con migration chua chay
echo [*] Kiem tra va dong bo cau truc Database...
"%PHP_CMD%" artisan migrate --force >nul 2>nul

echo [+] Dang su dung PHP: "%PHP_CMD%"
echo [+] Dang khoi dong may chu tai: http://127.0.0.1:8000
echo [*] Trinh duyet web se tu dong mo sau 2 giay...
echo [*] Nhan Ctrl + C de dung may chu.
echo ========================================================
echo.

REM Mo trinh duyet
start "" http://127.0.0.1:8000

REM Chay Laravel artisan serve
"%PHP_CMD%" artisan serve --host=127.0.0.1 --port=8000
pause
