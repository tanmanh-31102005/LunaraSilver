<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Update payments table to support 1 Order -> N Payment Attempts (Phase 13)
        Schema::table('payments', function (Blueprint $table) {
            // Drop unique constraint on order_id to allow multiple attempts
            // In MySQL, foreign key must be dropped first before dropping backing unique index
            if (DB::getDriverName() !== 'sqlite') {
                $hasUnique = collect(DB::select("SHOW INDEXES FROM payments WHERE Key_name = 'payments_order_id_unique'"))->isNotEmpty();
                if ($hasUnique) {
                    $table->dropForeign(['order_id']);
                    $table->dropUnique('payments_order_id_unique');
                    $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
                }
            }

            $table->string('txn_ref', 64)->nullable()->unique()->after('transaction_id');
            $table->string('vnp_transaction_no', 64)->nullable()->after('txn_ref');
            $table->string('vnp_bank_code', 30)->nullable()->after('vnp_transaction_no');
            $table->string('vnp_card_type', 30)->nullable()->after('vnp_bank_code');
            $table->string('vnp_pay_date', 30)->nullable()->after('vnp_card_type');
            $table->string('vnp_create_date', 14)->nullable()->after('vnp_pay_date');
            $table->timestamp('last_queried_at')->nullable()->after('paid_at');
            $table->unsignedInteger('query_count')->default(0)->after('last_queried_at');
            $table->text('failure_reason')->nullable()->after('query_count');
        });

        // 2. Create payment_refunds table for full & partial refund tracking
        Schema::create('payment_refunds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->constrained('payments')->cascadeOnDelete();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->string('request_id', 64)->unique();
            $table->string('refund_type', 20)->default('full'); // 'full' or 'partial'
            $table->decimal('amount', 15, 2);
            $table->string('status', 30)->default('requested'); // 'requested', 'processing', 'succeeded', 'failed', 'rejected'
            $table->text('reason')->nullable();
            $table->string('requested_by', 100)->nullable();
            $table->string('vnp_transaction_no', 64)->nullable();
            $table->string('vnp_response_code', 10)->nullable();
            $table->string('vnp_transaction_status', 10)->nullable();
            $table->json('request_payload')->nullable();
            $table->json('response_payload')->nullable();
            $table->timestamp('requested_at')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();

            $table->index(['order_id', 'status']);
            $table->index(['payment_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_refunds');

        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn([
                'txn_ref',
                'vnp_transaction_no',
                'vnp_bank_code',
                'vnp_card_type',
                'vnp_pay_date',
                'vnp_create_date',
                'last_queried_at',
                'query_count',
                'failure_reason',
            ]);

            if (DB::getDriverName() !== 'sqlite') {
                $table->unique('order_id', 'payments_order_id_unique');
            }
        });
    }
};
