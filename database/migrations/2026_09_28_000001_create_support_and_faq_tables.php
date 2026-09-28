<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('faqs')) {
            Schema::create('faqs', function (Blueprint $table) {
                $table->id();
                $table->string('category', 100);
                $table->string('question');
                $table->text('answer');
                $table->integer('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();

                $table->index(['category', 'is_active', 'sort_order']);
            });
        }

        if (! Schema::hasTable('contact_messages')) {
            Schema::create('contact_messages', function (Blueprint $table) {
                $table->id();
                $table->string('reference', 40)->unique();
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
                $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
                $table->string('name');
                $table->string('email');
                $table->string('phone', 30)->nullable();
                $table->string('subject');
                $table->text('message');
                $table->string('status', 30)->default('new'); // new, in_progress, resolved, closed
                $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
                $table->text('internal_notes')->nullable();
                $table->timestamps();

                $table->index(['status', 'created_at']);
                $table->index(['email', 'created_at']);
            });
        }

        if (! Schema::hasTable('support_conversations')) {
            Schema::create('support_conversations', function (Blueprint $table) {
                $table->id();
                $table->string('reference', 40)->unique();
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
                $table->string('guest_token', 64)->nullable()->index();
                $table->string('customer_name')->nullable();
                $table->string('customer_email')->nullable();
                $table->string('status', 30)->default('open'); // open, assigned, resolved, closed
                $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamp('last_message_at')->nullable();
                $table->timestamps();

                $table->index(['status', 'last_message_at']);
            });
        }

        if (! Schema::hasTable('support_messages')) {
            Schema::create('support_messages', function (Blueprint $table) {
                $table->id();
                $table->foreignId('conversation_id')->constrained('support_conversations')->cascadeOnDelete();
                $table->string('sender_type', 20); // customer, admin
                $table->foreignId('sender_id')->nullable()->constrained('users')->nullOnDelete();
                $table->string('sender_name')->nullable();
                $table->text('message');
                $table->timestamp('read_at')->nullable();
                $table->timestamps();

                $table->index(['conversation_id', 'created_at']);
                $table->index(['conversation_id', 'read_at']);
            });
        }

        if (! Schema::hasTable('email_logs')) {
            Schema::create('email_logs', function (Blueprint $table) {
                $table->id();
                $table->string('type', 50);
                $table->string('recipient');
                $table->string('related_type', 100)->nullable();
                $table->unsignedBigInteger('related_id')->nullable();
                $table->string('status', 20); // sent, failed
                $table->text('error_message')->nullable();
                $table->timestamp('sent_at')->nullable();
                $table->timestamps();

                $table->index(['type', 'status']);
                $table->index(['related_type', 'related_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('email_logs');
        Schema::dropIfExists('support_messages');
        Schema::dropIfExists('support_conversations');
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('faqs');
    }
};
