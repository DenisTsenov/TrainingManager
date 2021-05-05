<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(SettlementsTableSeeder::class);
        $this->call(SportsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(SettlementsSportsTableSeeder::class);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
