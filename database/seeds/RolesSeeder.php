<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $arr=['regular user', 'administrator', 'moderator', 'journalist', 'waived', 'blocked'];
        for($i=0; $i<count($arr); $i++){
            $role=new Role();
            $role->name=$arr[$i];
            $role->save();
        }
    }
}
