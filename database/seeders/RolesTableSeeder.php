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
            ['name' => 'Trainer', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Competitor', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        Role::where('id', 1)->first()->permissions()->attach([1, 2]);
        Role::where('id', 2)->first()->permissions()->attach([5]);
    }
}
