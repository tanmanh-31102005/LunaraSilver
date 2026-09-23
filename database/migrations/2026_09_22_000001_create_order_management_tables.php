<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add inventory_restored_at to orders
        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('inventory_restored_at')->nullable()->after('order_status');
        });

        // 2. Create order_item_components for detailed component snapshots (critical for safe bundle inventory restoration)
        Schema::create('order_item_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_item_id')->constrained('order_items')->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->string('product_sku');
            $table->string('product_name');
            $table->unsignedInteger('quantity_per_item');
            $table->unsignedInteger('total_quantity');
            $table->timestamps();
        });

        // 3. Create order_status_histories for audit logging and timeline tracking
        Schema::create('order_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->string('from_status')->nullable();
            $table->string('to_status');
            $table->foreignId('changed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('note')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_status_histories');
        Schema::dropIfExists('order_item_components');
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('inventory_restored_at');
        });
    }
};
