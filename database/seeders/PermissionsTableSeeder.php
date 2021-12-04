<?php

namespace Database\Seeders;

use App\Models\Admin\Permission;
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
            ['name' => config('constants.permissions.' .
                              Permission::CREATE_TRAINING), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => config('constants.permissions.' .
                              Permission::ASSIGN_TRAINING), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => config('constants.permissions.' .
                              Permission::EDIT_TRAINING), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => config('constants.permissions.' .
                              Permission::ROLLBACK_TRAINING), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => config('constants.permissions.' .
                              Permission::TRAINING_COMPLETE), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
