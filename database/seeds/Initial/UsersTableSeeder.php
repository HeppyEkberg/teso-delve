<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert([
            'name' => 'Heppy',
            'email' => 'tehheppy@gmail.com',
            'password' => bcrypt('secret'),
            'created_at' => \Carbon\Carbon::now(),
        ]);
    }
}
