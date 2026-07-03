<?php

namespace Database\Seeders;

use App\Models\BridalPackage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BridalPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Classic Bridal Package',
                'slug' => 'classic-bridal-package',
                'description' => 'A complete bridal look for the wedding day.',
                'includes' => ['HD bridal makeup', 'Hair styling', 'Draping', 'False lashes'],
                'price' => 22000,
                'duration_hours' => 4,
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Premium Bridal Package',
                'slug' => 'premium-bridal-package',
                'description' => 'Premium bridal glam with extra detailing and extended finishing time.',
                'includes' => ['Luxury bridal makeup', 'Advanced hair styling', 'Draping', 'Jewellery setting', 'Touch-up kit'],
                'price' => 32000,
                'discount_price' => 29000,
                'duration_hours' => 5,
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Engagement Package',
                'slug' => 'engagement-package',
                'description' => 'Soft glam makeup and hair for engagement or roka ceremonies.',
                'includes' => ['HD makeup', 'Hair styling', 'Draping'],
                'price' => 12000,
                'duration_hours' => 3,
                'sort_order' => 3,
            ],
        ];

        foreach ($packages as $package) {
            BridalPackage::updateOrCreate(['slug' => $package['slug']], $package);
        }
    }
}
