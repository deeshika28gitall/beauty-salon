<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bridal_packages', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('badge');
            $table->decimal('old_price', 10, 2)->nullable()->after('price');
            $table->string('duration_text')->nullable()->after('duration_hours');
            $table->text('short_description')->nullable()->after('description');
            $table->longText('full_description')->nullable()->after('short_description');
            $table->json('features')->nullable()->after('includes');
            $table->text('suitable_for')->nullable()->after('features');
            $table->text('important_notes')->nullable()->after('suitable_for');
        });
    }

    public function down(): void
    {
        Schema::table('bridal_packages', function (Blueprint $table) {
            $table->dropColumn([
                'image_path',
                'old_price',
                'duration_text',
                'short_description',
                'full_description',
                'features',
                'suitable_for',
                'important_notes',
            ]);
        });
    }
};
