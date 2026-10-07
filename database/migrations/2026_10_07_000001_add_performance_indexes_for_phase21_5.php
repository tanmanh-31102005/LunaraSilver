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
        Schema::table('orders', function (Blueprint $table) {
            $table->index(['order_status', 'created_at'], 'orders_status_created_at_idx');
            $table->index(['user_id', 'order_status', 'created_at'], 'orders_user_status_created_idx');
        });

        Schema::table('payment_refunds', function (Blueprint $table) {
            $table->index(['status', 'created_at'], 'payment_refunds_status_created_at_idx');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->index(['status', 'created_at'], 'reviews_status_created_at_idx');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->index(['is_active', 'product_type'], 'products_active_type_idx');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->index(['order_id', 'status'], 'payments_order_status_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex('payments_order_status_idx');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('products_active_type_idx');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropIndex('reviews_status_created_at_idx');
        });

        Schema::table('payment_refunds', function (Blueprint $table) {
            $table->dropIndex('payment_refunds_status_created_at_idx');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex('orders_status_created_at_idx');
            $table->dropIndex('orders_user_status_created_idx');
        });
    }
};
