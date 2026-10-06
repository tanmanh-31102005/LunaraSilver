import os
import ftplib
import urllib.request

FTP_HOST = 'ftpupload.net'
FTP_USER = 'if0_42986888'
FTP_PASS = 'manh31102005'
REMOTE_BASE = 'htdocs'

FILES_TO_UPLOAD = [
    # Controllers & Models
    'app/Http/Controllers/MediaController.php',
    'app/Models/Post.php',
    'database/seeders/BlogSeeder.php',
    'diag.php',

    # Views
    'resources/views/layouts/app.blade.php',
    'resources/views/admin/layouts/app.blade.php',
    'resources/views/components/hero-slider.blade.php',
    'resources/views/components/mega-menu.blade.php',
    'resources/views/emails/layout.blade.php',

    # CSS & Tokens
    'resources/css/tokens.css',
    'resources/css/app.css',

    # Vite build assets
    'public/build/manifest.json',
    'public/build/assets/app-EAhN-Jnr.css',
    'public/build/assets/admin-D6rjyDK-.css',
    'public/build/assets/app-D9FL5RAx.js',

    # WebP Previews
    'public/media-previews/hero.webp',
    'public/media-previews/hero-1.webp',
    'public/media-previews/hero-2.webp',
    'public/media-previews/hero-3.webp',
    'public/media-previews/aaa25111e73d445cc91fe54c2f69711d0770dc9b.webp',
    'public/media-previews/8864fea8744d49c046292b2ff57fc82c1d690a10.webp',
    'public/media-previews/afb9c5f571f7ac059df63464ff72977420d18522.webp',
    'public/media-previews/4adeae886168f4902e20fa35235e3a24a1ad1ca5.webp',
]

def ensure_remote_dir(ftp, remote_dir):
    parts = remote_dir.strip('/').split('/')
    cur = ''
    for part in parts:
        cur = f"{cur}/{part}" if cur else part
        try:
            ftp.mkd(cur)
        except Exception:
            pass

def wipe_remote_views_cache(ftp):
    views_dir = f"{REMOTE_BASE}/storage/framework/views"
    try:
        files = ftp.nlst(views_dir)
        count = 0
        for f in files:
            if f.endswith('.php'):
                try:
                    ftp.delete(f)
                    count += 1
                except Exception:
                    pass
        print(f"Purged {count} cached compiled views via FTP.")
    except Exception as e:
        print("Note on wiping view cache:", e)

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

    wipe_remote_views_cache(ftp)
    ftp.quit()
    print(f"\nUploaded {success_count}/{len(FILES_TO_UPLOAD)} files successfully!")

    print("\nTriggering cache clear & post synchronization via diag.php...")
    try:
        req = urllib.request.Request(
            'https://lunarasilver.infinityfreeapp.com/diag.php?clear_cache=1&sync_posts=1',
            headers={'User-Agent': 'Mozilla/5.0'}
        )
        with urllib.request.urlopen(req, timeout=15) as res:
            html = res.read().decode('utf-8', errors='ignore')
            if 'Đã xóa sạch cache' in html:
                print("SUCCESS: Cache cleared on InfinityFree!")
            if 'Đã đồng bộ' in html:
                print("SUCCESS: Database posts synced to banner2.jpg / banner3.jpg!")
            else:
                print("Diag response:", html[:300])
    except Exception as e:
        print("Note on diag.php:", e)

if __name__ == '__main__':
    main()
