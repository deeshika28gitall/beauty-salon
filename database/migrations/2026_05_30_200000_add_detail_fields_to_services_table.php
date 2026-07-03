<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('hero_image_path')->nullable()->after('slug');
            $table->string('short_description')->nullable()->after('hero_image_path');
            $table->text('full_description')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['hero_image_path', 'short_description', 'full_description']);
        });
    }
};
