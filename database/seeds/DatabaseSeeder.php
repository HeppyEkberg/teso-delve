<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UsersTableSeeder::class);
         $this->call(SetSeeder::class);
         $this->call(DungeonSeeder::class);
         $this->call(DailyPledgesSeeder::class);
         $this->call(RoleSeeder::class);
    }
}
