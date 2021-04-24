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
        $sports = [
            'Weightlifting', 'Tennis', 'Snooker', 'Darts', 'Powerlifting',
        ];

        foreach ($sports as $sport) {
            Sport::create([
                'name' => $sport,
            ]);
        }
    }
}
