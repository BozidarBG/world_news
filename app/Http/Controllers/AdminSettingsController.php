<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use Session;

class AdminSettingsController extends Controller
{
    public function __construct(){
        $this->middleware('administrator');
    }

    public function edit()
    {
        return view('admin.settings.edit');
    }


    public function update(Request $request)
    {
        $this->validate($request, [

            'email'=>'required|email',
            'address'=>'required|string',
            'name'=>'required|string',
            'about'=>'required|string'

        ]);

        $settings=Setting::first();
        $settings->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'address'=>$request->address,
            'about'=>$request->about
        ]);

        Session::flash('success', 'Settings updated successfully');
        return redirect()->back();
    }

}
