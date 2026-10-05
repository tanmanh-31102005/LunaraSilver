import os
import ftplib
import urllib.request

FTP_HOST = 'ftpupload.net'
FTP_USER = 'if0_42986888'
FTP_PASS = 'manh31102005'
REMOTE_BASE = 'htdocs'

FILES_TO_UPLOAD = [
    # Views
    'resources/views/account/orders/show.blade.php',
    'resources/views/admin/layouts/app.blade.php',
    'resources/views/components/seo/meta.blade.php',
    'resources/views/layouts/app.blade.php',

    # Public favicons & icons
    'public/favicon.ico',
    'public/favicon-16x16.png',
    'public/favicon-32x32.png',
    'public/favicon.png',
    'public/apple-touch-icon.png',
    'public/android-chrome-192x192.png',
    'public/android-chrome-512x512.png',

    # Root favicons & icons
    'favicon.ico',
    'favicon-16x16.png',
    'favicon-32x32.png',
    'favicon.png',
    'apple-touch-icon.png',
    'android-chrome-192x192.png',
    'android-chrome-512x512.png',

    # Product media files
    'media/Product/dc004.jpg',
    'media/Product/nh004.jpg',
    'media/Product/dc0010.jpg',

    # Webp previews
    'public/media-previews/1220106db4953be528c228476a400fd6c579e4d0.webp',
    'public/media-previews/40abd3105f1908a30d00720694156f3325794ae1.webp',
    'public/media-previews/b9fd7e19791282aa9348b9d777ebe3181fd6181e.webp',
    'public/media-previews/d281e7422f4b1c982836035cc6dc1d1c5e5bdc3e.webp',
]

def ensure_remote_dir(ftp, remote_dir):
    parts = remote_dir.strip('/').split('/')
    cur = ''
    for part in parts:
        cur = f"{cur}/{part}" if cur else part
        try:
            ftp.mkd(cur)
            print(f"Created remote dir: {cur}")
        except Exception:
            pass

def main():
    print(f"Connecting to FTP {FTP_HOST} as {FTP_USER}...")
    ftp = ftplib.FTP(FTP_HOST, timeout=60)
    ftp.login(FTP_USER, FTP_PASS)
    ftp.set_pasv(True)
    print("Logged in successfully!")

    success_count = 0
    for rel_path in FILES_TO_UPLOAD:
        local_path = os.path.normpath(rel_path)
        if not os.path.exists(local_path):
            print(f"WARNING: Local file not found: {local_path}")
            continue

        remote_path = f"{REMOTE_BASE}/{rel_path.replace(os.sep, '/')}"
        remote_dir = os.path.dirname(remote_path)
        ensure_remote_dir(ftp, remote_dir)

        print(f"Uploading {rel_path} -> {remote_path} ({os.path.getsize(local_path)} bytes)...")
        with open(local_path, 'rb') as f:
            ftp.storbinary(f"STOR {remote_path}", f)
        success_count += 1

    ftp.quit()
    print(f"\nUploaded {success_count}/{len(FILES_TO_UPLOAD)} files successfully!")

    print("\nTriggering cache clear via diag.php?clear_cache=1...")
    try:
        req = urllib.request.Request(
            'https://lunarasilver.infinityfreeapp.com/diag.php?clear_cache=1',
            headers={'User-Agent': 'Mozilla/5.0'}
        )
        with urllib.request.urlopen(req, timeout=15) as res:
            html = res.read().decode('utf-8', errors='ignore')
            if 'Đã xóa sạch cache' in html:
                print("SUCCESS: Cache cleared on InfinityFree!")
            else:
                print("Server responded to diag.php (code 200).")
    except Exception as e:
        print("Note on diag.php:", e)

if __name__ == '__main__':
    main()
