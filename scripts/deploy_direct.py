import os
import ftplib
import urllib.request

FTP_HOST = 'ftpupload.net'
FTP_USER = 'if0_42986888'
FTP_PASS = 'manh31102005'
REMOTE_BASE = 'htdocs'

FILES_TO_UPLOAD = [
    # Bootstrap & Middleware
    'bootstrap/app.php',
    'app/Http/Middleware/SecurityHeadersMiddleware.php',

    # Routes & Core Models
    'routes/web.php',
    'app/Models/User.php',
    'app/Http/Controllers/MediaController.php',
    'app/Models/Post.php',
    'database/seeders/BlogSeeder.php',
    'diag.php',

    # Admin Controllers & Services
    'app/Http/Controllers/Admin/DashboardController.php',
    'app/Http/Controllers/Admin/CustomerController.php',
    'app/Http/Controllers/Admin/AdminSearchController.php',
    'app/Http/Controllers/Admin/ExportController.php',
    'app/Services/Admin/AnalyticsService.php',
    'app/Services/Admin/AttentionService.php',
    'app/Services/Admin/CustomerInsightsService.php',
    'app/Services/Admin/AdminSearchService.php',
    'app/Services/Admin/ExportService.php',

    # Storefront & Shared Views
    'resources/views/home.blade.php',
    'resources/views/layouts/app.blade.php',
    'resources/views/components/hero-slider.blade.php',
    'resources/views/components/mega-menu.blade.php',
    'resources/views/components/search-overlay.blade.php',
    'resources/views/components/cart-drawer.blade.php',
    'resources/views/products/_reviews_section.blade.php',
    'resources/views/emails/layout.blade.php',

    # Admin Views & Customer Tabs
    'resources/views/admin/layouts/app.blade.php',
    'resources/views/admin/dashboard.blade.php',
    'resources/views/admin/customers/index.blade.php',
    'resources/views/admin/customers/show.blade.php',
    'resources/views/admin/customers/tabs/orders.blade.php',
    'resources/views/admin/customers/tabs/reviews.blade.php',
    'resources/views/admin/customers/tabs/support.blade.php',
    'resources/views/admin/customers/tabs/coupons.blade.php',
    'resources/views/admin/customers/tabs/addresses.blade.php',

    # Custom Error Pages (Phase 23)
    'resources/views/errors/layout.blade.php',
    'resources/views/errors/404.blade.php',
    'resources/views/errors/403.blade.php',
    'resources/views/errors/419.blade.php',
    'resources/views/errors/429.blade.php',
    'resources/views/errors/500.blade.php',
    'resources/views/errors/503.blade.php',

    # Documentation & Migrations
    'docs/backup_and_recovery.md',
    'database/migrations/2026_10_07_000001_add_performance_indexes_for_phase21_5.php',

    # CSS & JS Source
    'resources/css/tokens.css',
    'resources/css/app.css',
    'resources/js/app.js',
    'resources/js/search-overlay.js',

    # Vite build assets (Phase 23 compilation)
    'public/build/manifest.json',
    'public/build/assets/app-DNC1TOfE.css',
    'public/build/assets/admin-D6rjyDK-.css',
    'public/build/assets/app-e57kuO4T.js',
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
            'https://lunarasilver.infinityfreeapp.com/diag.php?clear_cache=1&sync_posts=1&migrate_indexes=1',
            headers={'User-Agent': 'Mozilla/5.0'}
        )
        with urllib.request.urlopen(req, timeout=15) as res:
            html = res.read().decode('utf-8', errors='ignore')
            if 'Đã xóa sạch cache' in html:
                print("SUCCESS: Cache cleared on InfinityFree!")
            if 'Đã đồng bộ' in html:
                print("SUCCESS: Database posts synced to banner2.jpg / banner3.jpg!")
            if 'indexes hiệu năng' in html:
                print("SUCCESS: Performance indexes applied to production DB!")
            else:
                print("Diag response:", html[:300])
    except Exception as e:
        print("Note on diag.php:", e)

if __name__ == '__main__':
    main()
