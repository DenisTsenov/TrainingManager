<?php

namespace Database\Seeders;

use App\Models\Settlemet;
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
        $settlements = [
            'Sofiq', 'Varna', 'Plovdiv', 'Sliven', 'Kneja',
        ];

        foreach ($settlements as $settlement) {
            Settlemet::create([
                'name' => $settlement
            ]);
        }
    }
}
