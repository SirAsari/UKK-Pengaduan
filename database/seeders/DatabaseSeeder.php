<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'masyarakat',
            'email' => 'masyarakat@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password123'),
            'role' => 'USER',
            'remember_token' => null,
        ]);

        User::create([
            'name' => 'staff',
            'email' => 'staff@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password123'),
            'role' => 'STAFF',
            'remember_token' => null,
        ]);

        User::create([
            'name' => 'headstaff',
            'email' => 'headstaff@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password123'),
            'role' => 'HEAD_STAFF',
            'remember_token' => null,
        ]);

    }
}
