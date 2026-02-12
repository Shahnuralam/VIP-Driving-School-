<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instructors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('email')->unique();
            $table->string('phone');
            $table->text('bio')->nullable();
            $table->text('qualifications')->nullable();
            $table->integer('years_experience')->default(0);
            $table->string('photo')->nullable();
            $table->string('license_number')->nullable();
            $table->date('license_expiry')->nullable();
            $table->json('specializations')->nullable(); // ['manual', 'automatic', 'heavy_vehicle', etc.]
            $table->json('available_days')->nullable(); // ['monday', 'tuesday', etc.]
            $table->time('available_from')->default('08:00');
            $table->time('available_to')->default('18:00');
            $table->json('service_areas')->nullable(); // suburb/location IDs
            $table->decimal('rating', 3, 2)->default(5.00);
            $table->integer('total_reviews')->default(0);
            $table->integer('total_lessons')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Instructor availability exceptions (holidays, blocked dates)
        Schema::create('instructor_unavailabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instructor_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->time('start_time')->nullable(); // null means whole day
            $table->time('end_time')->nullable();
            $table->string('reason')->nullable();
            $table->timestamps();

            $table->index(['instructor_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instructor_unavailabilities');
        Schema::dropIfExists('instructors');
    }
};
