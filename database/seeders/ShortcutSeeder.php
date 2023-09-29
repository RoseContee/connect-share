<?php

namespace Database\Seeders;

use App\Models\Shortcut;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShortcutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Shortcut::create([
            'title' => 'Gmail',
            'icon' => 'uploads/side-icons/gmail.png',
            'link' => 'https://mail.google.com/mail/',
            'active' => true,
        ]);
        Shortcut::create([
            'title' => 'Google Calendar',
            'icon' => 'uploads/side-icons/google-calendar.png',
            'link' => 'https://calendar.google.com/calendar',
            'active' => true,
        ]);
        Shortcut::create([
            'title' => 'Google Drive',
            'icon' => 'uploads/side-icons/google-drive.png',
            'link' => 'https://drive.google.com/',
            'active' => true,
        ]);
        Shortcut::create([
            'title' => 'Google Meet',
            'icon' => 'uploads/side-icons/google-meet.png',
            'link' => 'https://meet.google.com/',
            'active' => true,
        ]);
    }
}
