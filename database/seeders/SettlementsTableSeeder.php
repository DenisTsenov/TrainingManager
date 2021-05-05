<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettlementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('settlements')->truncate();

        \DB::table('settlements')->insert([
            ['name' => 'Sofiq'],
            ['name' => 'Varna'],
            ['name' => 'Plovdiv'],
            ['name' => 'Sliven'],
            ['name' => 'Kneja'],
        ]);
    }
}
