"""Build non-destructive catalog previews from the Phase 3 local images.

Run from the project root: python scripts/build_media_previews.py
Requires Pillow. Original media files are read only.
"""

import hashlib
import json
from pathlib import Path

from PIL import Image, ImageOps


ROOT = Path(__file__).resolve().parents[1]
CATALOG = ROOT / "database/data/catalog.json"
OUTPUT = ROOT / "public/media-previews"


def main():
    images = json.loads(CATALOG.read_text(encoding="utf-8"))["images"]
    OUTPUT.mkdir(parents=True, exist_ok=True)

    for item in images:
        relative = item["path"]
        source = ROOT / relative
        if not source.is_file():
            raise FileNotFoundError(f"{item['sku']} image_url: {relative}")

        target = OUTPUT / f"{hashlib.sha1(relative.encode('utf-8')).hexdigest()}.webp"
        with Image.open(source) as original:
            preview = ImageOps.exif_transpose(original)
            if relative.startswith("media/Gift/"):
                # Gift artwork includes printed prices that differ from Excel.
                # Crop only the browser preview; the source image stays intact.
                preview = preview.crop((0, 0, preview.width, int(preview.height * 0.84)))
            preview.thumbnail((720, 900), Image.Resampling.LANCZOS)
            preview.save(target, "WEBP", quality=82, method=6)

    hero_banners = [
        ("media/banner.jpg", "hero.webp"),
        ("media/banner2.png", "hero-2.webp"),
        ("media/banner3.png", "hero-3.webp"),
    ]
    for rel_path, out_name in hero_banners:
        banner_file = ROOT / rel_path
        if banner_file.is_file():
            with Image.open(banner_file) as original:
                banner = ImageOps.exif_transpose(original)
                if banner.width > 1920:
                    ratio = 1920 / banner.width
                    banner = banner.resize((1920, int(banner.height * ratio)), Image.Resampling.LANCZOS)
                banner.save(OUTPUT / out_name, "WEBP", quality=84, method=6)

    print(f"Built {len(images)} catalog previews and 3 hero previews in {OUTPUT.relative_to(ROOT)}")


if __name__ == "__main__":
    main()
