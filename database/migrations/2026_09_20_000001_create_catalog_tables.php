<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->index()->constrained()->restrictOnDelete();
            $table->string('sku')->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('product_type', 20)->index();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->decimal('regular_price', 15, 2);
            $table->decimal('sale_price', 15, 2)->nullable();
            $table->unsignedInteger('stock_quantity')->default(0);
            $table->string('stock_status', 20)->default('out_of_stock');
            $table->string('material')->nullable();
            $table->string('stone')->nullable();
            $table->string('weight')->nullable();
            $table->text('size_info')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true)->index();
            $table->unsignedInteger('sold_count')->default(0);
            $table->unsignedInteger('view_count')->default(0);
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->index()->constrained()->cascadeOnDelete();
            $table->string('cloudinary_public_id')->nullable();
            $table->text('image_url');
            $table->string('image_role', 20);
            $table->integer('sort_order')->default(0);
            $table->string('alt_text')->nullable();
            $table->timestamps();
        });

        Schema::create('bundle_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bundle_product_id')->index()->constrained('products')->cascadeOnDelete();
            $table->foreignId('component_product_id')->index()->constrained('products')->cascadeOnDelete();
            $table->unsignedInteger('quantity')->default(1);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->unique(['bundle_product_id', 'component_product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bundle_items');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
    }
};
