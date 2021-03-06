<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     * set 'created_at' => Carbon::now(), 'updated_at' => Carbon::now() because QueryBuilder dose not know
     * what to insert automatically unlike Eloquent
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->truncate();

        DB::table('permissions')->insert([
            ['name' => 'Create Training', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Assign Training', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Edit Training', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Rollback Training', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Training Complete', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
