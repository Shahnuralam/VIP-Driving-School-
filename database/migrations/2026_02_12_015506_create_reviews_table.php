<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('package_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('instructor_id')->nullable()->constrained()->nullOnDelete();
            
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_location')->nullable();
            
            // Ratings (1-5)
            $table->tinyInteger('overall_rating');
            $table->tinyInteger('instructor_rating')->nullable();
            $table->tinyInteger('vehicle_rating')->nullable();
            $table->tinyInteger('value_rating')->nullable();
            
            $table->string('title')->nullable();
            $table->text('content');
            $table->text('admin_response')->nullable();
            $table->timestamp('admin_responded_at')->nullable();
            
            // Moderation
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->foreignId('moderated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('moderated_at')->nullable();
            
            $table->boolean('is_featured')->default(false);
            $table->boolean('show_on_homepage')->default(false);
            $table->integer('helpful_count')->default(0);
            
            // Review request tracking
            $table->string('review_token')->unique()->nullable();
            $table->timestamp('review_requested_at')->nullable();
            
            $table->timestamps();

            $table->index(['status', 'overall_rating']);
            $table->index('instructor_id');
        });

        // Track helpful votes
        Schema::create('review_helpful', function (Blueprint $table) {
            $table->id();
            $table->foreignId('review_id')->constrained()->onDelete('cascade');
            $table->string('ip_address');
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();

            $table->unique(['review_id', 'ip_address']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('review_helpful');
        Schema::dropIfExists('reviews');
    }
};
