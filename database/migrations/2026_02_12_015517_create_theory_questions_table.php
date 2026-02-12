<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('theory_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('theory_category_id')->constrained()->onDelete('cascade');
            $table->text('question');
            $table->string('question_image')->nullable();
            $table->enum('question_type', ['single', 'multiple', 'true_false'])->default('single');
            $table->json('options'); // ['A' => 'Option A', 'B' => 'Option B', ...]
            $table->json('correct_answers'); // ['A'] or ['A', 'B'] for multiple
            $table->text('explanation')->nullable();
            $table->string('explanation_image')->nullable();
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('medium');
            $table->integer('points')->default(1);
            $table->integer('times_answered')->default(0);
            $table->integer('times_correct')->default(0);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['theory_category_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('theory_questions');
    }
};
