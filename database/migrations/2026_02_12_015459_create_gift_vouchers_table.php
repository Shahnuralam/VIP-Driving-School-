<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gift_vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->enum('type', ['fixed', 'package'])->default('fixed'); // fixed amount or specific package
            $table->decimal('amount', 10, 2)->nullable(); // for fixed type
            $table->foreignId('package_id')->nullable()->constrained()->nullOnDelete(); // for package type
            $table->decimal('balance', 10, 2)->default(0); // remaining balance
            
            // Purchaser info
            $table->string('purchaser_name');
            $table->string('purchaser_email');
            $table->string('purchaser_phone')->nullable();
            
            // Recipient info
            $table->string('recipient_name');
            $table->string('recipient_email');
            $table->text('message')->nullable();
            
            // Payment
            $table->string('stripe_payment_intent_id')->nullable();
            $table->string('stripe_charge_id')->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            
            // Status
            $table->enum('status', ['active', 'partially_used', 'fully_used', 'expired', 'cancelled'])->default('active');
            $table->date('expires_at');
            $table->timestamp('redeemed_at')->nullable();
            $table->foreignId('redeemed_by')->nullable()->constrained('customers')->nullOnDelete();
            $table->foreignId('redeemed_booking_id')->nullable()->constrained('bookings')->nullOnDelete();
            
            $table->boolean('email_sent')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gift_vouchers');
    }
};
