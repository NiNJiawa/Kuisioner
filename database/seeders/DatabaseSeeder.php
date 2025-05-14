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
        // User::factory(10)->create();

        User::create([
            'name' => 'Refani',
            'username' => 'refani',
            'phone' => '08123456789',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Najwa',
            'username' => 'najwa',
            'phone' => '08123456789',
            'password' => Hash::make('password12'),
        ]);

        $this->call([
            OptionsTableSeeder::class,
            PassionsTableSeeder::class,
            QuestionsTableSeeder::class,
            PassionQuestionMapSeeder::class,
        ]);
    }
}
