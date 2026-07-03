<?php

namespace Database\Seeders;

use App\Models\ContactSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactSetting::updateOrCreate(
            ['studio_name' => 'Kharbanda Makeup Studio'],
            [
                'phone' => '+91 98765 43210',
                'whatsapp' => '+91 98765 43210',
                'email' => 'hello@kharbandamakeupstudio.com',
                'address' => 'Kharbanda Makeup Studio, Main Market',
                'city' => 'Delhi',
                'instagram_url' => 'https://www.instagram.com/kharbandamakeupstudio',
                'facebook_url' => 'https://www.facebook.com/kharbandamakeupstudio',
                'map_url' => null,
                'business_hours' => [
                    'monday' => '10:00 AM - 7:00 PM',
                    'tuesday' => '10:00 AM - 7:00 PM',
                    'wednesday' => '10:00 AM - 7:00 PM',
                    'thursday' => '10:00 AM - 7:00 PM',
                    'friday' => '10:00 AM - 7:00 PM',
                    'saturday' => '10:00 AM - 7:00 PM',
                    'sunday' => 'By appointment',
                ],
                'is_active' => true,
            ]
        );
    }
}
