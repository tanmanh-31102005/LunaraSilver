# Lunara Silver — Phase 4

Laravel 12 + Eloquent + Blade + Bootstrap + Vite. Phase 4 adds the storefront layout, reusable Blade components, and a homepage backed by the Phase 3 catalog. Product listing/detail, cart, checkout, and admin UI are not implemented yet. Source documents and media remain in `docs/`, `media/`, and `.claude/`.

## Local setup (Windows / XAMPP)

The project uses the existing `lunara_silver` database on `127.0.0.1:3306`. The local XAMPP installation exposes MariaDB through Laravel's MySQL driver. Do not create tables manually; migrations manage the schema.

1. Start MySQL in XAMPP.
2. If `.env` is missing, copy `.env.example` to `.env` and set `DB_PASSWORD` locally if your root account needs one. Keep `.env` private.
3. If `APP_KEY` is empty, run `& 'C:\xampp\php\php.exe' artisan key:generate`.
4. Run `& 'C:\xampp\php\php.exe' artisan migrate`.
5. Run `npm ci`, then `npm run dev` in one terminal.
6. Run `& 'C:\xampp\php\php.exe' artisan serve` in another terminal.
7. Open `http://127.0.0.1:8000`.

For a production asset build, use `npm run build`. On this machine Composer is at `$env:LOCALAPPDATA\Composer\composer.phar`; run it with `& 'C:\xampp\php\php.exe' -d extension=zip "$env:LOCALAPPDATA\Composer\composer.phar" install` if dependencies need reinstalling.

8. Run `& 'C:\xampp\php\php.exe' artisan db:seed` to import the catalog. Running it again updates rows by stable SKU without creating duplicates.

Run `& 'C:\xampp\php\php.exe' artisan test` to check model relationships, authentication, and catalog imports. Public registration always creates a `user`. The `admin` role exists in the users schema for later phases. No user or operational settings are seeded.

## Catalog data provenance

`database/data/catalog.json` was generated from `docs/ProductData.xlsx` (sheets `6.2 San pham` and `6.3 Set va qua tang`) and the existing files under `media/Product/`, `media/Collection/`, and `media/Gift/`. To regenerate after approved source changes, install Python `openpyxl` and run `python scripts/normalize_catalog.py`, review the JSON diff, then run `artisan db:seed`. The Laravel seeders read only the normalized JSON and validate it before writing in a transaction.

The workbook has no stock quantity for collections or gifts. The existing schema requires an integer, so these 15 products retain `stock_quantity = 0`. Their `Giá set` is stored as `regular_price`; `Giá mua lẻ (tổng)` is not a sale price, so `sale_price` is null. Gift 4 includes a charm and candle without retail SKUs; their original text is preserved in `short_description`, while only the referenced catalog SKU becomes a bundle item. Gift 5 contains two units of `LNS-NH001`.

## Inventory model

For a `single`, `products.stock_quantity` is the source of truth. For a `collection` or `gift`, inventory is virtual: `Product::availableQuantity()` returns the minimum of `floor(component.stock_quantity / bundle_items.quantity)` over its components. An empty or invalid bundle has availability zero. `Product::isInStock()` uses that computed quantity. Bundle stock is not stored separately; its `stock_quantity = 0` and database `stock_status` are schema placeholders and must not drive business logic or UI.

For lists, eager load `bundleItems.component` before calling `availableQuantity()`. Without eager loading, each call queries current component stock. After a stock write, refresh any previously eager loaded products before recalculating. Future checkout must aggregate requirements across single items and bundle components in the same cart before decrementing component stock; cart reservation and checkout are not part of this phase.

All 10 collections now have a primary `(1)` and hover `(2)` image, including `LNS-SET006` (`set 6(1).jpg.png` and `set 6(2).jpg.png`). Local paths in `product_images.image_url` are relative to the project root. No Cloudinary upload is used.

## Storefront and media

`HomeController` loads active categories, single products, collections, and gifts with Eloquent. Product cards and stock state use the shared Blade components and `Product::isInStock()`. If `is_featured` has no selected products, the homepage shows the first four single products in SKU order under the neutral heading “Khám phá Lunara”. Blog, search, wishlist, cart, and product detail actions remain disabled until their phases; navigation links point only to live homepage anchors or the existing auth routes. The announcement bar is hidden by default and can be set using `LUNARA_ANNOUNCEMENT` in `.env` after its content is approved.

The originals stay in `media/`. `MediaController` serves allowed images from this directory through a read-only `/media/{path}` route, with real-path checks against directory traversal. `scripts/build_media_previews.py` creates smaller WebP copies in `public/media-previews/` for catalog cards and the hero banner; install Python Pillow and rerun it after an approved media change. `ProductImage::displayUrl()` uses the preview when present, falls back to the local media route, and accepts a future external HTTPS image URL without changing Blade. Source files are not modified.

Collection and gift cards use computed bundle availability. Their database `stock_quantity = 0` and `stock_status` are not used for storefront decisions. Purchasing CTAs are not enabled in Phase 4. Gift source artwork contains printed prices which may differ from the authoritative Excel catalog; the generated gift previews crop that lower portion and the card displays the database price separately. Replace or approve the artwork before publishing an original-image viewer or product detail page.
