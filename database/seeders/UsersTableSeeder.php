<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();

        factory(User::class, 50)->create();

        User::create([
            'first_name' => 'Denis',
            'last_name'  => 'Tsenov',
            'email'      => 'denis@test.bg',
            'password'   => 'password',
            'is_admin'   => true,
            'role_id'    => 1,
        ]);
    }
}
