<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "3 x 50 Minute Lesson"
            $table->string('slug')->unique();
            $table->integer('lesson_count'); // Number of lessons in package
            $table->integer('lesson_duration')->default(50); // Minutes per lesson
            $table->decimal('price', 10, 2);
            $table->decimal('original_price', 10, 2)->nullable(); // For showing savings
            $table->text('description')->nullable();
            $table->text('tagline')->nullable(); // e.g., "An Affordable and Practical Start"
            $table->integer('validity_days')->default(365); // Valid for 1 year
            $table->string('validity_text')->default('Valid for one year');
            $table->boolean('is_featured')->default(false); // "Most Popular" badge
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
