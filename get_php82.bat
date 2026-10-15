@echo off
setlocal EnableDelayedExpansion
title LUNARA SILVER - TAI PHP 8.2 PORTABLE
cls

echo ========================================================
echo        TU DONG TAI VA CAI DAT PHP 8.2 PORTABLE
echo ========================================================
echo.
echo May cua ban dang chay ban PHP thap hon 8.2 (vi du PHP 8.0 tren XAMPP).
echo Script nay se tai ban PHP 8.2 Portable chinh chu ve thu muc du an (khoang 32MB).
echo.
echo - Khong lam anh huong den XAMPP cu tren may ban.
echo - Khong can go cai dat bat cu thu gi.
echo - Tu dong cau hinh day du extension (pdo_mysql, gd, zip, curl...).
echo ========================================================
echo.

powershell -NoProfile -ExecutionPolicy Bypass -File "%~dp0scripts\get_php82.ps1"

if %errorlevel% equ 0 (
    echo ========================================================
    echo      DA CAI DAT PHP 8.2 PORTABLE THANH CONG!
    echo ========================================================
    echo Bay gio ban hay chay lai file: setup.bat hoac start.bat
    echo ========================================================
) else (
    echo.
    echo [ERROR] Co loi xay ra khi tai PHP 8.2. Vui long kiem tra ket noi Internet.
)
pause
