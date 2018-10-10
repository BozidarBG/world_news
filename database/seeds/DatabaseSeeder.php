<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
//$this->call(RolesSeeder::class);
        //$this->call(UsersSeeder::class);
        //factory(\App\Article::class, 300)->create();
        //$this->call(SettingTableSeeder::class);
        factory(\App\Reply::class, 1000)->create();
    }
}
