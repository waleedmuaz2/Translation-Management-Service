<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'mobile',
            'desktop',
            'web',
            'admin',
            'user',
            'error',
            'success',
            'notification',
            'email',
            'sms'
        ];

        foreach ($tags as $tag) {
            Tag::create(['name' => $tag]);
        }
    }
} 