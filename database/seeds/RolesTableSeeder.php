<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('roles')->insert([
            ['name' => 'trainer', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'competitor', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
