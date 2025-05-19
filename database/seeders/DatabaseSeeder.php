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

    // User::factory(10)->create();

    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'phone' => '08123456780',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // User biasa
        User::create([
            'name' => 'Refani',
            'username' => 'refani',
            'phone' => '08123456789',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Najwa',
            'username' => 'najwa',
            'phone' => '08123456789',
            'password' => Hash::make('password12'),
            'role' => 'user',
        ]);

        $this->call([
            OptionsTableSeeder::class,
            PassionsTableSeeder::class,
            QuestionsTableSeeder::class,
            PassionQuestionMapSeeder::class,
        ]);
    }
}
