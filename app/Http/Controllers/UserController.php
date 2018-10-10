<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Hash;
use Hashids\Hashids;

class UserController extends Controller
{

    public function __construct(){
        $this->middleware('administrator')->except(['index']);
    }


    public function index()
    {
        return view('admin.users.index')
            ->with('users', User::where('role_id','!=', 1)->get());
    }


    public function create()
    {
        return view('admin.users.create')->with('roles', Role::all());
    }


    public function store(Request $request)
    {

        $this->validate($request, [
            'name'=>'required|string|max:190',
            'email'=>'required|email|unique:users|max:190',
            'password'=>'required|min:6|max:190',
            'role'=>'required'
        ]);

        $lastId=User::count() ? User::latest()->first()->id : 0;
        $hashids = new Hashids('korisnici', 10);
        $hash_id=$hashids->encode($lastId+1);

        User::create([
            'hashid'=>$hash_id,
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role_id'=>$request->role
        ]);

        Session::flash('success', 'User created successfully!!');
        return redirect()->back();
    }


    public function edit($hashid)
    {
        return view('admin.users.edit')->with('user', User::where('hashid', $hashid)->first());
    }


    public function update(Request $request, $hashid)
    {
        $this->validate($request, [
            'name'=>'required|string|max:190',
            'email'=>'required|email|max:190',

            'role'=>'required'
        ]);
        $user=User::findOrFail($hashid);
        $user->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role_id'=>$request->role
        ]);

        Session::flash('success', 'User updated successfully!!');
        return redirect()->back();
    }

}

