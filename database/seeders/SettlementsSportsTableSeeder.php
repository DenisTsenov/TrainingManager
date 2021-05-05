<?php

namespace Database\Seeders;

use App\Models\Settlement;
use App\Models\Sport;
use Illuminate\Database\Seeder;

class SettlementsSportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('settlement_sport')->truncate();

        $settlements = Settlement::get();
        $sports      = Sport::get();

        for ($settlementId = 1; $settlementId <= $settlements->count(); $settlementId++) {
            for ($sportId = 1; $sportId <= rand(1, $sports->count()); $sportId++) {
                \DB::table('settlement_sport')->insert([
                    'settlement_id' => $settlementId,
                    'sport_id'      => $sportId,
                ]);
            }
        }
    }
}
