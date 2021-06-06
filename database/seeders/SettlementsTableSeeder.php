<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class SettlementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('settlements')->truncate();

        \DB::table('settlements')->insert([
            ['name' => 'Sofiq', 'created_by' => User::SEED + 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Varna', 'created_by' => User::SEED + 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Plovdiv', 'created_by' => User::SEED + 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sliven', 'created_by' => User::SEED + 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kneja', 'created_by' => User::SEED + 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
