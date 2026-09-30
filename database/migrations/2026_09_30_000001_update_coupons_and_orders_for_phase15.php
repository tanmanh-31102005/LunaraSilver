<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Update coupons table
        if (Schema::hasTable('coupons')) {
            Schema::table('coupons', function (Blueprint $table) {
                if (! Schema::hasColumn('coupons', 'usage_limit_per_user')) {
                    $table->unsignedInteger('usage_limit_per_user')->nullable()->after('usage_limit');
                }
            });
        }

        // 2. Update coupon_usages table
        if (Schema::hasTable('coupon_usages')) {
            Schema::table('coupon_usages', function (Blueprint $table) {
                if (! Schema::hasColumn('coupon_usages', 'status')) {
                    $table->string('status', 20)->default('applied')->after('order_id');
                }
                if (! Schema::hasColumn('coupon_usages', 'used_at')) {
                    $table->timestamp('used_at')->nullable()->after('status');
                }
                if (! Schema::hasColumn('coupon_usages', 'released_at')) {
                    $table->timestamp('released_at')->nullable()->after('used_at');
                }
            });
        }

        // 3. Update orders table
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (! Schema::hasColumn('orders', 'coupon_code')) {
                    $table->string('coupon_code', 50)->nullable()->after('subtotal');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'coupon_code')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('coupon_code');
            });
        }

        if (Schema::hasTable('coupon_usages')) {
            Schema::table('coupon_usages', function (Blueprint $table) {
                $cols = [];
                if (Schema::hasColumn('coupon_usages', 'status')) {
                    $cols[] = 'status';
                }
                if (Schema::hasColumn('coupon_usages', 'used_at')) {
                    $cols[] = 'used_at';
                }
                if (Schema::hasColumn('coupon_usages', 'released_at')) {
                    $cols[] = 'released_at';
                }
                if (! empty($cols)) {
                    $table->dropColumn($cols);
                }
            });
        }

        if (Schema::hasTable('coupons') && Schema::hasColumn('coupons', 'usage_limit_per_user')) {
            Schema::table('coupons', function (Blueprint $table) {
                $table->dropColumn('usage_limit_per_user');
            });
        }
    }
};
