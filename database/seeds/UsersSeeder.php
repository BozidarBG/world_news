<?php

use Illuminate\Database\Seeder;
use App\User;
use Hashids\Hashids;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
//        $names=['John Wall', 'James Harden', 'Victor Oladipo', 'Nikola Jokic', 'Kevin Love', 'Al Horford', 'Garry Harris', 'Kevin Durant', 'Anthony Davis', 'Chriss Paul', 'Goran Dragic', 'Boban Marjanovic', 'Kawhi Leonard', 'Joel Embiid', 'Marcus Smart', 'Paul George', 'Dirk Novitzky', 'Blake Griffin'];
//
//
//        for($i=0; $i<count($names); $i++){
//
//            $hashids = new Hashids('korisnici', 10);
//            $hash_id=$hashids->encode($i+3);
//            $user=new User();
//            $user->name=$names[$i];
//            $user->hashid=$hash_id;
//            $email=trim(strstr($names[$i], " "))."@gmail.com";
//            $user->email=strtolower($email);
//            $user->role_id=4;
//            $user->password=Hash::make('111111');
//            $user->save();
//        }

    }
}
