<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use \App\Models\Admin\Role;

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
        DB::table('permission_role')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('roles')->insert([
            ['name' => 'Trainer', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Competitor', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        $trainer = Role::where('id', 1)->first();
        $trainer->permissions()->attach([1, 2]);

        $competitor = Role::where('id', 2)->first();
        $competitor->permissions()->attach([5]);
    }
}
