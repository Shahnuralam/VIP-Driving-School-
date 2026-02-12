<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('newsletter_subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('name')->nullable();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('status', ['pending', 'subscribed', 'unsubscribed'])->default('pending');
            $table->string('confirmation_token')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->string('unsubscribe_token')->nullable();
            $table->timestamp('unsubscribed_at')->nullable();
            $table->string('source')->default('website'); // website, booking, checkout
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });

        // Email campaigns
        Schema::create('email_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('subject');
            $table->text('preview_text')->nullable();
            $table->longText('content');
            $table->enum('status', ['draft', 'scheduled', 'sending', 'sent', 'cancelled'])->default('draft');
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->integer('recipients_count')->default(0);
            $table->integer('opens_count')->default(0);
            $table->integer('clicks_count')->default(0);
            $table->integer('bounces_count')->default(0);
            $table->integer('unsubscribes_count')->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // Automated email triggers
        Schema::create('automated_emails', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('trigger'); // after_booking, after_lesson, abandoned_cart, birthday, etc.
            $table->integer('delay_hours')->default(0);
            $table->string('subject');
            $table->longText('content');
            $table->boolean('is_active')->default(true);
            $table->integer('sent_count')->default(0);
            $table->timestamps();
        });

        // Track sent automated emails
        Schema::create('automated_email_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('automated_email_id')->constrained()->onDelete('cascade');
            $table->string('email');
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('booking_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('status', ['sent', 'failed', 'opened', 'clicked'])->default('sent');
            $table->timestamp('opened_at')->nullable();
            $table->timestamp('clicked_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('automated_email_logs');
        Schema::dropIfExists('automated_emails');
        Schema::dropIfExists('email_campaigns');
        Schema::dropIfExists('newsletter_subscribers');
    }
};
