<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class SportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('sports')->truncate();

        \DB::table('sports')->insert([
            ['name' => 'Weightlifting', 'created_by' => User::SEED + 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tennis', 'created_by' => User::SEED + 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Snooker', 'created_by' => User::SEED + 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Darts', 'created_by' => User::SEED + 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Powerlifting', 'created_by' => User::SEED + 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
