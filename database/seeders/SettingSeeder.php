<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Setting::doesntExist()) {
            Setting::create([
                'name' => 'Stoutes',
                'logo' => 'logo.png',
                'theme_color' => '#1979ce',
                'favicon' => 'favicon.ico'
            ]);
        }
    }
}
