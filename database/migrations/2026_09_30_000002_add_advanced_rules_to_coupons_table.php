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
        Schema::table('coupons', function (Blueprint $table) {
            if (! Schema::hasColumn('coupons', 'is_first_order_only')) {
                $table->boolean('is_first_order_only')->default(false)->after('is_active');
            }
            if (! Schema::hasColumn('coupons', 'applicable_categories')) {
                $table->json('applicable_categories')->nullable()->after('is_first_order_only');
            }
            if (! Schema::hasColumn('coupons', 'applicable_products')) {
                $table->json('applicable_products')->nullable()->after('applicable_categories');
            }
            if (! Schema::hasColumn('coupons', 'applicable_customer_ids')) {
                $table->json('applicable_customer_ids')->nullable()->after('applicable_products');
            }
            if (! Schema::hasColumn('coupons', 'applicable_customer_emails')) {
                $table->json('applicable_customer_emails')->nullable()->after('applicable_customer_ids');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn([
                'is_first_order_only',
                'applicable_categories',
                'applicable_products',
                'applicable_customer_ids',
                'applicable_customer_emails',
            ]);
        });
    }
};
