<?php

use Illuminate\Database\Seeder;
use App\Setting;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting=new Setting();
        $setting->name="World News";
        $setting->email="bozidar.djordjevic@gmail.com";
        $setting->address="Gandijeva 37a<br>11070 New Belgrade<br>Serbia";
        $setting->about="Welcome visitor!<br><br>My name is Božidar Djordjević and this website is one of my first projects in Laravel. It's purpose is to show my skills as a future web developer and hopefully help me get my first job.";
        $setting->save();
    }
}
