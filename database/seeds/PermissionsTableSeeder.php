<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * set 'created_at' => Carbon::now(), 'updated_at' => Carbon::now() because QueryBuilder dose not know
     * what to insert automatically unlike Eloquent
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('permissions')->truncate();

        DB::table('permissions')->insert([
            ['name' => 'create_training', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'assign_training', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'edit_training', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'roll_back_training', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'training_complete', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
