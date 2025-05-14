<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PassionQuestionMapSeeder extends Seeder
{
    public function run()
    {
        $mapping = [
            'SC' => [13, 33, 53, 73, 77],
            'IF' => [8, 28, 48, 68, 88],
            'SB' => [21, 41, 61, 81, 90],
            'PL' => [11, 17, 31, 51, 71],
            'SE' => [5, 18, 45, 65, 85],
            'CC' => [19, 34, 39, 59, 79],
            'EL' => [7, 27, 47, 67, 87],
            'MI' => [2, 22, 42, 62, 82],
            'PK' => [14, 40, 58, 75, 78],
            'PD/IX' => [16, 36, 54, 56, 76],
            'XL' => [3, 23, 43, 63, 83],
            'CT' => [1, 10, 30, 50, 70,],
            'SD' => [20, 38, 55, 60, 80],
            'EG' => [15, 25, 35, 57, 74],
            'HL' => [6, 26, 46, 66, 86],
            'CH' => [4, 24, 44, 64, 84],
            'SP' => [12, 32, 37, 52, 72],
            'SA' => [9, 29,  49, 69, 89],
        ];

        foreach ($mapping as $code => $questionIds) {
            $passion = DB::table('passions')->where('code', $code)->first();
            if ($passion) {
                foreach ($questionIds as $question_id) {
                    DB::table('passion_question_maps')->insert([
                        'passion_id' => $passion->id,
                        'question_id' => $question_id,
                    ]);
                }
            }
        }
    }
}
