<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin exists
        if (!User::where('email', 'admin@ossaga.com')->exists()) {
            User::create([
                'name' => 'Admin OSSAGA',
                'email' => 'admin@ossaga.com',
                'password' => Hash::make('password'), // Default password
            ]);
        }
    }
}
