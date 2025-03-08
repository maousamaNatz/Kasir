<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'current_team_id' => null,
            'profile_photo_path' => null,
            'remember_token' => null,
        ]);

        User::factory()->create([
            'name' => 'Kasir',
            'email' => 'kasir@kasir.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'current_team_id' => null,
            'profile_photo_path' => null,
            'remember_token' => null,
        ]);
    }
}
