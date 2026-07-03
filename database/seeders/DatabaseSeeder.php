<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ServiceSeeder::class,
            BridalPackageSeeder::class,
            TestimonialSeeder::class,
            ContactSettingSeeder::class,
            HeroSlideSeeder::class,
            NavMenuItemSeeder::class,
            AdminUserSeeder::class,
        ]);
    }
}
