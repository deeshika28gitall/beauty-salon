<?php

namespace Database\Seeders;

use App\Models\NavMenuItem;
use Illuminate\Database\Seeder;

class NavMenuItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['label' => 'Gallery', 'href' => '/gallery', 'sort_order' => 1, 'is_active' => true, 'open_in_new_tab' => false],
            ['label' => 'Testimonials', 'href' => '#testimonials', 'sort_order' => 2, 'is_active' => true, 'open_in_new_tab' => false],
            ['label' => 'Contact', 'href' => '#contact', 'sort_order' => 3, 'is_active' => true, 'open_in_new_tab' => false],
        ];

        foreach ($items as $item) {
            NavMenuItem::updateOrCreate(
                ['label' => $item['label'], 'href' => $item['href']],
                $item
            );
        }
    }
}
