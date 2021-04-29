<?php

namespace Database\Seeders;

use App\Models\Sport;
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
            ['name' => 'Weightlifting'],
            ['name' => 'Tennis'],
            ['name' => 'Snooker'],
            ['name' => 'Darts'],
            ['name' => 'Powerlifting'],
        ]);
    }
}
