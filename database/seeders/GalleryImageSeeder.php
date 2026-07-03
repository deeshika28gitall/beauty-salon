<?php

namespace Database\Seeders;

use App\Models\GalleryImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GalleryImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $images = [
            [
                'title' => 'Royal Bridal Look',
                'image_path' => 'gallery/royal-bridal-look.jpg',
                'category' => 'bridal',
                'alt_text' => 'Royal bridal makeup look by Kharbanda Makeup Studio',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Soft Engagement Glam',
                'image_path' => 'gallery/soft-engagement-glam.jpg',
                'category' => 'engagement',
                'alt_text' => 'Soft engagement makeup look',
                'sort_order' => 2,
            ],
            [
                'title' => 'Reception Makeup',
                'image_path' => 'gallery/reception-makeup.jpg',
                'category' => 'reception',
                'alt_text' => 'Reception makeup and hairstyling',
                'sort_order' => 3,
            ],
        ];

        foreach ($images as $image) {
            GalleryImage::updateOrCreate(['image_path' => $image['image_path']], $image);
        }
    }
}
