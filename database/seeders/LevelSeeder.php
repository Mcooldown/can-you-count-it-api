<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    public function run()
    {
        DB::table('levels')->insert([
            [
                "name" => "Beginner",
                'operator' => '+',
                "play_time" => 120,
                "round_time" => 24,
                "correct_score" => 4,
                "incorrect_score" => 1
            ],
            [
                "name" => "Intermediate",
                'operator' => '+',
                "play_time" => 120,
                "round_time" => 16,
                "correct_score" => 6,
                "incorrect_score" => 2,
            ],
            [
                "name" => "Advanced",
                'operator' => '+',
                "play_time" => 120,
                "round_time" => 12,
                "correct_score" => 8,
                "incorrect_score" => 4,
            ],
            [
                "name" => "Expert",
                'operator' => '+',
                "play_time" => 120,
                "round_time" => 8,
                "correct_score" => 16,
                "incorrect_score" => 8,
            ],
            [
                "name" => "Beginner",
                'operator' => '-',
                "play_time" => 120,
                "round_time" => 24,
                "correct_score" => 4,
                "incorrect_score" => 1
            ],
        ]);
    }
}
