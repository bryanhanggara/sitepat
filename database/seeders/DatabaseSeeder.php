<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin account
        User::updateOrCreate(
            ['email' => 'admin@eticket.test'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '628111111111',
            ]
        );

        // Regular user account
        User::updateOrCreate(
            ['email' => 'user@eticket.test'],
            [
                'name' => 'User Demo',
                'password' => Hash::make('password'),
                'role' => 'user',
                'phone' => '628122222222',
            ]
        );
    }
}
