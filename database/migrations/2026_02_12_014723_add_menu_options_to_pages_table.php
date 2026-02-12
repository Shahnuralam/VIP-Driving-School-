<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->boolean('show_in_navbar')->default(false)->after('is_active');
            $table->boolean('show_in_footer')->default(true)->after('show_in_navbar');
            $table->integer('navbar_order')->default(0)->after('show_in_footer');
            $table->integer('footer_order')->default(0)->after('navbar_order');
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['show_in_navbar', 'show_in_footer', 'navbar_order', 'footer_order']);
        });
    }
};
