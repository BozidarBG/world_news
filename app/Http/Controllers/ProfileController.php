<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Session;

class ProfileController extends Controller
{
    protected $user;
    public function findUser()
    {
        $this->user=Auth::user();
    }

    //admins will have profile edit in admin layout and regular users in frontend layout
    //all will use the same template but on different layouts
    public function edit(Request $request)
    {
        $this->findUser();

        if($this->user->role_id===2 || $this->user->role_id===3 || $this->user->role_id===4){
            $view='/admin/profile';
        }elseif($this->user->role_id===1){
            $view='/profile';
        }
        return view($view)->with("user",$this->user );
    }


    public function update(Request $request)
    {
        $this->findUser();
        $this->validate($request, [
            'password'=>'required|min:6|string'
        ]);
        $this->user->password=Hash::make($request->password);
        $this->user->save();

        Session::flash('success','Profile updated successfully!');
        return redirect()->back();
    }

    /**
    When user deletes it's profile, we want to keep his comments and replies, if he has any
      - if he has replies, his table row will be updated: email->null, name="deleted user", role_id = 6
      - if he doesnt have replies or comments, delete entire table row
     */
    public function destroy(Request $request)
    {
        $this->findUser();
        if($this->user->comments->count()>0 || $this->user->replies->count()>0){
            $this->user->name="Deleted user";
            $this->user->email=null;
            $this->user->role_id=6;
            $this->user->save();
        }else{
            $this->user->delete();
        }
        return redirect('/');
    }
}
