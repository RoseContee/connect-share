<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::upsert([[
            'key' => 'favicon',
            'value' => null,
        ], [
            'key' => 'logo',
            'value' => null,
        ], [
            'key' => 'contact_email',
            'value' => null,
        ], [
            'key' => 'contact_phone',
            'value' => null,
        ], [
            'key' => 'banner_image',
            'value' => null,
        ], [
            'key' => 'shortcut',
            'value' => true,
        ], [
            'key' => 'dark_mode',
            'value' => false,
        ]], ['key']);
    }
}
