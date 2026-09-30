<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('post_categories', function (Blueprint $table) {
            if (! Schema::hasColumn('post_categories', 'description')) {
                $table->text('description')->nullable()->after('slug');
            }
            if (! Schema::hasColumn('post_categories', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('description');
            }
            if (! Schema::hasColumn('post_categories', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('sort_order');
            }
        });

        Schema::table('posts', function (Blueprint $table) {
            if (! Schema::hasColumn('posts', 'author_id')) {
                $table->foreignId('author_id')->nullable()->after('post_category_id')->constrained('users')->nullOnDelete();
            }
            if (! Schema::hasColumn('posts', 'cover_image_url')) {
                $table->text('cover_image_url')->nullable()->after('image_url');
            }
            if (! Schema::hasColumn('posts', 'cloudinary_public_id')) {
                $table->string('cloudinary_public_id')->nullable()->after('cover_image_url');
            }
            if (! Schema::hasColumn('posts', 'status')) {
                $table->string('status', 32)->default('draft')->after('is_published');
            }
            if (! Schema::hasColumn('posts', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('status');
            }
            if (! Schema::hasColumn('posts', 'reading_time_minutes')) {
                $table->integer('reading_time_minutes')->default(0)->after('is_featured');
            }
            if (! Schema::hasColumn('posts', 'seo_title')) {
                $table->string('seo_title')->nullable()->after('reading_time_minutes');
            }
            if (! Schema::hasColumn('posts', 'seo_description')) {
                $table->text('seo_description')->nullable()->after('seo_title');
            }
        });

        // Sync status with is_published for any pre-existing posts
        try {
            DB::table('posts')
                ->where('is_published', true)
                ->update(['status' => 'published']);
        } catch (Throwable $e) {
            // Ignore if in test memory database before rows exist
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $dropCols = [];
            foreach ([
                'seo_description',
                'seo_title',
                'reading_time_minutes',
                'is_featured',
                'status',
                'cloudinary_public_id',
                'cover_image_url',
                'author_id',
            ] as $col) {
                if (Schema::hasColumn('posts', $col)) {
                    $dropCols[] = $col;
                }
            }
            if (! empty($dropCols)) {
                $table->dropColumn($dropCols);
            }
        });

        Schema::table('post_categories', function (Blueprint $table) {
            $dropCols = [];
            foreach (['is_active', 'sort_order', 'description'] as $col) {
                if (Schema::hasColumn('post_categories', $col)) {
                    $dropCols[] = $col;
                }
            }
            if (! empty($dropCols)) {
                $table->dropColumn($dropCols);
            }
        });
    }
};
