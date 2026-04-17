<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 👤 user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // 🏫 school (VERY IMPORTANT 🔥)
        DB::table('schools')->insert([
            'name' => 'Skolira School',
            'slug' => 'skolira',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}