<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptionsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('options')->insert([
            ['label' => 'TS', 'score' => 0],
            ['label' => 'SdS', 'score' => 1],
            ['label' => 'CS', 'score' => 2],
            ['label' => 'SS', 'score' => 3],
        ]);
    }
}
