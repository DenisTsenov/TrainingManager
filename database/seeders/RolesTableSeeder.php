<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use \App\Models\Admin\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->truncate();
        DB::table('permission_role')->truncate();

        DB::table('roles')->insert([
            ['name' => config('constants.roles.' . Role::TRAINER), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => config('constants.roles.' . Role::COMPETITOR), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        Role::where('id', Role::TRAINER)->first()->permissions()->attach([1, 2]);
        Role::where('id', Role::COMPETITOR)->first()->permissions()->attach([5]);
    }
}
