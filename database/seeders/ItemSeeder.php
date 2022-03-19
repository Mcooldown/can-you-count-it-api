<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    public function run()
    {
        DB::table('items')->insert([
            [
                "type" => "FREEZE",
                "name" => "Freeze Time interval for 5 seconds",
                "cost" => 300,
                "number" => 5
            ],
            [
                "type" => "FREEZE",
                "name" => "Freeze Time interval for 10 seconds",
                "cost" => 600,
                "number" => 5
            ],
            [
                "type" => "FREEZE",
                "name" => "Freeze Time interval for 15 seconds",
                "cost" => 1000,
                "number" => 5
            ],
            [
                "type" => "NUMBER-MANIPULATION",
                "name" => "Guarantee the result between 0-10 for 5 seconds",
                "cost" => 300,
                "number" => 5
            ],
            [
                "type" => "NUMBER-MANIPULATION",
                "name" => "Guarantee the result between 0-10 for 10 seconds",
                "cost" => 500,
                "number" => 5
            ],
            [
                "type" => "NUMBER-MANIPULATION",
                "name" => "Guarantee the result between 0-10 for 15 seconds",
                "cost" => 800,
                "number" => 5
            ],
        ]);
    }
}
