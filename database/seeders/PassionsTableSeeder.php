<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PassionsTableSeeder extends Seeder
{
    public function run()
    {
        $passions = [
            ['name' => 'Systemic Change', 'code' => 'SC'],
            ['name' => 'Innovative & Foresight-Driven Impact', 'code' => 'IF'],
            ['name' => 'Structured-System Builder', 'code' => 'SB'],
            ['name' => 'Public Governance & Leadership', 'code' => 'PL'],
            ['name' => 'Social Change & Empowerment', 'code' => 'SE'],
            ['name' => 'Creative Communication & Expression', 'code' => 'CC'],
            ['name' => 'Education & Learning Bridge', 'code' => 'EL'],
            ['name' => 'Meaningful & Sustainable Impact', 'code' => 'MI'],
            ['name' => 'Policy & Knowledge Synthesis', 'code' => 'PK'],
            ['name' => 'Interdisciplinary Exploration', 'code' => 'PD/IX'],
            ['name' => 'Experimental Leadership', 'code' => 'XL'],
            ['name' => 'Catalyst & Connector', 'code' => 'CT'],
            ['name' => 'Spiritual-Driven Purpose', 'code' => 'SD'],
            ['name' => 'Empowering Growth', 'code' => 'EG'],
            ['name' => 'Healing & Wellbeing Oriented', 'code' => 'HL'],
            ['name' => 'Cultural Heritage & Identity', 'code' => 'CH'],
            ['name' => 'Sustainability & Planet Stewardship', 'code' => 'SP'],
            ['name' => 'Social Storytelling & Advocacy', 'code' => 'SA'],
        ];

        DB::table('passions')->insert($passions);
    }
}
