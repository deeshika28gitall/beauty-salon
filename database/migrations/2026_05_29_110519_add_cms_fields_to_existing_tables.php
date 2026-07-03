<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('icon')->nullable()->after('image_path');
        });

        Schema::table('bridal_packages', function (Blueprint $table) {
            $table->string('badge')->nullable()->after('duration_hours');
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->string('client_role')->nullable()->after('client_name');
        });

        Schema::table('contact_settings', function (Blueprint $table) {
            $table->text('map_embed_url')->nullable()->after('map_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('icon');
        });

        Schema::table('bridal_packages', function (Blueprint $table) {
            $table->dropColumn('badge');
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn('client_role');
        });

        Schema::table('contact_settings', function (Blueprint $table) {
            $table->dropColumn('map_embed_url');
        });
    }
};
