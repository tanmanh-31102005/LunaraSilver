<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->foreignId('order_item_id')->nullable()->after('product_id')->constrained('order_items')->cascadeOnDelete();
            $table->string('title', 120)->nullable()->after('rating');
            $table->text('content')->nullable()->after('title');
            $table->boolean('verified_purchase')->default(false)->after('status');
            $table->text('admin_reply')->nullable()->after('verified_purchase');
            $table->timestamp('admin_replied_at')->nullable()->after('admin_reply');
            $table->foreignId('admin_replied_by')->nullable()->after('admin_replied_at')->constrained('users')->nullOnDelete();
            $table->text('rejection_reason')->nullable()->after('admin_replied_by');

            $table->index(['product_id', 'status']);
            $table->index(['user_id', 'status']);
            $table->unique('order_item_id');
        });

        Schema::create('review_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('review_id')->constrained('reviews')->cascadeOnDelete();
            $table->string('public_id')->nullable();
            $table->string('image_url');
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['review_id', 'sort_order']);
        });

        Schema::table('cart_items', function (Blueprint $table) {
            $table->string('gift_message', 500)->nullable()->after('unit_price');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->string('gift_message', 500)->nullable()->after('subtotal');
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('gift_message');
        });

        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropColumn('gift_message');
        });

        Schema::dropIfExists('review_media');

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['order_item_id']);
            $table->dropForeign(['admin_replied_by']);
            $table->dropUnique(['order_item_id']);
            $table->dropIndex(['product_id', 'status']);
            $table->dropIndex(['user_id', 'status']);
            $table->dropColumn([
                'order_item_id',
                'title',
                'content',
                'verified_purchase',
                'admin_reply',
                'admin_replied_at',
                'admin_replied_by',
                'rejection_reason',
            ]);
        });
    }
};
