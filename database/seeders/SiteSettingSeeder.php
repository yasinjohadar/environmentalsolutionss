<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        SiteSetting::updateOrCreate(
            ['id' => 1],
            [
                'site_name' => 'حلول بيئية',
                'footer_description' => 'نقدم خدمات متكاملة لجمع وإعادة تدوير النفايات الإلكترونية بطرق آمنة وصديقة للبيئة.',
            ]
        );
        SiteSetting::clearCache();
    }
}
