<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Customer account link
            $table->foreignId('customer_id')->nullable()->after('id')->constrained()->nullOnDelete();
            
            // Instructor assignment
            $table->foreignId('instructor_id')->nullable()->after('customer_id')->constrained()->nullOnDelete();
            
            // Coupon/discount
            $table->foreignId('coupon_id')->nullable()->after('amount')->constrained()->nullOnDelete();
            $table->decimal('discount_amount', 10, 2)->default(0)->after('coupon_id');
            $table->decimal('original_amount', 10, 2)->nullable()->after('discount_amount');
            
            // Gift voucher
            $table->foreignId('gift_voucher_id')->nullable()->after('discount_amount')->constrained()->nullOnDelete();
            $table->decimal('voucher_amount_used', 10, 2)->default(0)->after('gift_voucher_id');
            
            // Recurring booking
            $table->foreignId('parent_booking_id')->nullable()->after('gift_voucher_id')->constrained('bookings')->nullOnDelete();
            $table->boolean('is_recurring')->default(false)->after('parent_booking_id');
            $table->string('recurring_frequency')->nullable()->after('is_recurring'); // weekly, fortnightly
            $table->integer('recurring_count')->nullable()->after('recurring_frequency');
            
            // Review tracking
            $table->boolean('review_requested')->default(false)->after('admin_notes');
            $table->timestamp('review_requested_at')->nullable()->after('review_requested');
            
            // Source tracking
            $table->string('booking_source')->default('website')->after('review_requested_at'); // website, admin, phone, app
            $table->string('utm_source')->nullable()->after('booking_source');
            $table->string('utm_medium')->nullable()->after('utm_source');
            $table->string('utm_campaign')->nullable()->after('utm_medium');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropForeign(['instructor_id']);
            $table->dropForeign(['coupon_id']);
            $table->dropForeign(['gift_voucher_id']);
            $table->dropForeign(['parent_booking_id']);
            
            $table->dropColumn([
                'customer_id', 'instructor_id', 'coupon_id', 'discount_amount', 
                'original_amount', 'gift_voucher_id', 'voucher_amount_used',
                'parent_booking_id', 'is_recurring', 'recurring_frequency', 'recurring_count',
                'review_requested', 'review_requested_at',
                'booking_source', 'utm_source', 'utm_medium', 'utm_campaign'
            ]);
        });
    }
};
