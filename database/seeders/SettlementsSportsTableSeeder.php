<?php

namespace Database\Seeders;

use App\Models\Settlemet;
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
        \DB::table('settlements_sports')->truncate();

        $settlements = Settlemet::get();
        $sports      = Sport::get();

        for ($settlementId = 1; $settlementId <= $settlements->count(); $settlementId++) {
            for ($sportId = 1; $sportId <= rand(1, $sports->count()); $sportId++) {
                \DB::table('settlements_sports')->insert([
                    'settlement_id' => $settlementId,
                    'sport_id'      => $sportId,
                ]);
            }
        }
    }
}
