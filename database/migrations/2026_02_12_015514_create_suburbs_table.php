<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suburbs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('postcode')->nullable();
            $table->string('state')->default('TAS');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            
            // SEO landing page content
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('hero_title')->nullable();
            $table->text('hero_description')->nullable();
            $table->string('hero_image')->nullable();
            $table->longText('content')->nullable();
            
            // Features/highlights
            $table->json('features')->nullable(); // ['Experienced instructors', 'Flexible scheduling', etc.]
            $table->text('local_routes_info')->nullable();
            $table->text('test_center_info')->nullable();
            
            // Service info
            $table->boolean('is_serviced')->default(true);
            $table->decimal('travel_fee', 8, 2)->nullable(); // extra fee if any
            $table->integer('min_booking_hours')->nullable();
            
            $table->boolean('show_on_map')->default(true);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Link suburbs to instructors
        Schema::create('instructor_suburb', function (Blueprint $table) {
            $table->foreignId('instructor_id')->constrained()->onDelete('cascade');
            $table->foreignId('suburb_id')->constrained()->onDelete('cascade');
            $table->primary(['instructor_id', 'suburb_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instructor_suburb');
        Schema::dropIfExists('suburbs');
    }
};
