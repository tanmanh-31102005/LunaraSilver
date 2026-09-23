<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use InvalidArgumentException;

class Product extends Model
{
    use SoftDeletes;

    private const EFFECTIVE_PRICE_SQL = 'CAST(CASE WHEN sale_price IS NOT NULL AND sale_price >= 0 AND sale_price <= regular_price THEN sale_price ELSE regular_price END AS DECIMAL(18,2))';

    public const TYPES = ['single', 'collection', 'gift'];

    public const STOCK_STATUSES = ['in_stock', 'out_of_stock'];

    protected $fillable = [
        'category_id', 'sku', 'name', 'slug', 'product_type', 'short_description',
        'description', 'regular_price', 'sale_price', 'stock_quantity', 'stock_status',
        'material', 'stone', 'weight', 'size_info', 'is_featured', 'is_active',
        'sold_count', 'view_count', 'seo_title', 'seo_description',
    ];

    protected $casts = [
        'regular_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'sold_count' => 'integer',
        'view_count' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $product): void {
            if (! in_array($product->product_type, self::TYPES, true)) {
                throw new InvalidArgumentException('Invalid product type.');
            }

            if ($product->product_type === 'single') {
                $product->stock_status = $product->stock_quantity > 0 ? 'in_stock' : 'out_of_stock';
            }

            if (! in_array($product->stock_status ?? 'out_of_stock', self::STOCK_STATUSES, true)) {
                throw new InvalidArgumentException('Invalid stock status.');
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('image_role', 'primary');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function bundleItems(): HasMany
    {
        return $this->hasMany(BundleItem::class, 'bundle_product_id')->orderBy('sort_order');
    }

    public function bundleComponents(): BelongsToMany
    {
        return $this->belongsToMany(self::class, 'bundle_items', 'bundle_product_id', 'component_product_id')
            ->using(BundleItem::class)
            ->withPivot('quantity', 'sort_order')
            ->withTimestamps()
            ->orderByPivot('sort_order');
    }

    public function isBundle(): bool
    {
        return in_array($this->product_type, ['collection', 'gift'], true);
    }

    public function availableQuantity(): int
    {
        if ($this->product_type === 'single') {
            return max(0, $this->stock_quantity);
        }

        // An unloaded relation is queried each call so component stock changes
        // are visible. Lists can eager load bundleItems.component to avoid N+1.
        $items = $this->relationLoaded('bundleItems')
            ? $this->bundleItems->loadMissing('component')
            : $this->bundleItems()->with('component')->get();

        if ($items->isEmpty()) {
            return 0;
        }

        $available = PHP_INT_MAX;
        foreach ($items as $item) {
            if ($item->quantity < 1 || ! $item->component || $item->component->product_type !== 'single') {
                return 0;
            }

            $available = min($available, intdiv(max(0, $item->component->stock_quantity), $item->quantity));
        }

        return $available;
    }

    public function isInStock(): bool
    {
        return $this->availableQuantity() > 0;
    }

    public function hasValidSalePrice(): bool
    {
        if ($this->sale_price === null) {
            return false;
        }

        $regular = (int) str_replace('.', '', $this->regular_price);
        $sale = (int) str_replace('.', '', $this->sale_price);

        return $sale >= 0 && $sale <= $regular;
    }

    public function discountPercent(): ?int
    {
        if (! $this->hasValidSalePrice()) {
            return null;
        }

        $regular = (int) str_replace('.', '', $this->regular_price);
        $sale = (int) str_replace('.', '', $this->sale_price);

        return $regular > $sale ? intdiv(($regular - $sale) * 100, $regular) : null;
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if ($term === null || trim($term) === '') {
            return $query;
        }

        $pattern = '%'.trim($term).'%';

        return $query->where(function (Builder $search) use ($pattern): void {
            $search->where('name', 'like', $pattern)
                ->orWhere('sku', 'like', $pattern)
                ->orWhere('short_description', 'like', $pattern)
                ->orWhere('description', 'like', $pattern);
        });
    }

    public function scopeCategory(Builder $query, ?Category $category): Builder
    {
        return $category ? $query->where('category_id', $category->id) : $query;
    }

    public function scopePriceRange(Builder $query, ?string $min, ?string $max): Builder
    {
        if ($min !== null) {
            $query->whereRaw(self::EFFECTIVE_PRICE_SQL.' >= ?', [$min]);
        }
        if ($max !== null) {
            $query->whereRaw(self::EFFECTIVE_PRICE_SQL.' <= ?', [$max]);
        }

        return $query;
    }

    public function scopeProductType(Builder $query, ?string $type): Builder
    {
        return $type !== null ? $query->where('product_type', $type) : $query;
    }

    public function scopeMaterial(Builder $query, ?string $material): Builder
    {
        return $material !== null ? $query->where('material', $material) : $query;
    }

    public function scopeStone(Builder $query, ?string $stone): Builder
    {
        return $stone !== null ? $query->where('stone', $stone) : $query;
    }

    public function scopeSort(Builder $query, string $sort): Builder
    {
        return match ($sort) {
            'price_asc' => $query->orderByRaw(self::EFFECTIVE_PRICE_SQL.' ASC')->orderBy('id'),
            'price_desc' => $query->orderByRaw(self::EFFECTIVE_PRICE_SQL.' DESC')->orderByDesc('id'),
            'name_asc' => $query->orderBy('name')->orderBy('id'),
            default => $query->orderByDesc('created_at')->orderByDesc('id'),
        };
    }
}
