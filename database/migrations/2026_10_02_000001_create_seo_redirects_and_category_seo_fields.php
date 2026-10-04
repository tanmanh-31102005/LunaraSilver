<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Add SEO fields to categories if they don't already exist
        Schema::table('categories', function (Blueprint $table) {
            if (! Schema::hasColumn('categories', 'seo_title')) {
                $table->string('seo_title')->nullable()->after('description');
            }
            if (! Schema::hasColumn('categories', 'seo_description')) {
                $table->text('seo_description')->nullable()->after('seo_title');
            }
            if (! Schema::hasColumn('categories', 'seo_intro')) {
                $table->text('seo_intro')->nullable()->after('seo_description');
            }
        });

        // 2. Create SEO redirects table for URL & slug change stability
        if (! Schema::hasTable('seo_redirects')) {
            Schema::create('seo_redirects', function (Blueprint $table) {
                $table->id();
                $table->string('old_path', 500)->unique();
                $table->string('new_path', 500);
                $table->unsignedSmallInteger('status_code')->default(301);
                $table->timestamp('created_at')->useCurrent();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('seo_redirects')) {
            Schema::dropIfExists('seo_redirects');
        }

        Schema::table('categories', function (Blueprint $table) {
            $drop = [];
            foreach (['seo_intro', 'seo_description', 'seo_title'] as $col) {
                if (Schema::hasColumn('categories', $col)) {
                    $drop[] = $col;
                }
            }
            if (! empty($drop)) {
                $table->dropColumn($drop);
            }
        });
    }
};
