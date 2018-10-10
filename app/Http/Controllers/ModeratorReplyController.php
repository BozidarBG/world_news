<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reply;
use App\Comment;
use Session;
use Auth;
use Log;

class ModeratorReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('moderator')->except(['store']);;
    }


    public function unapproved()
    {
        return view('admin.comments.index')
            ->with('items', Reply::where('approved', 0)->orderBy('created_at', 'desc')->paginate(20))
            ->with('page_name', 'Unapproved replies')
            ;
    }

    public function approved()
    {
        return view('admin.comments.index')
            ->with('items', Reply::where('approved', 1)->orderBy('created_at', 'desc')->paginate(20))
            ->with('page_name', 'Approved replies');
    }



    public function store(Request $request)
    {
        //dd($request->all());
        if(!$comment_id=Comment::findOrFail($request->name)->first()->id){
            return redirect()->back();
        }
        $this->validate($request, [
            'body'=>'required|string|min:2|max:1000',
        ]);

        $reply=new Reply();
        $reply->comment_id=$comment_id;
        $reply->user_id=Auth::id();
        $reply->body=$request->body;
        $reply->save();
        Session::flash('success', 'Reply sent to approval successfully!');
        return redirect()->back();

    }

    public function update(Request $request)
    {

        $this->validate($request, [
            'id'=>'numeric'
        ]);

        $reply=Reply::find($request->id);
        if($reply->approved){
            $reply->approved=false;
            $reply->approved_by=false;
        }else{
            $reply->approved=true;
            $reply->approved_by=Auth::id();
        }

        if($reply->save()){

            return response()->json(['success'=>'Reply updated successfully!','id'=>$request->id]);
        }else{

            return response()->json(['error'=>'Opps, something was wrong!']);
        }
    }


    public function destroy(Request $request)
    {
        $reply=Reply::findOrFail($request->id);

        if($reply->delete()){
            return response()->json(['success'=>'Reply deleted successfully!','id'=>$request->id]);
        }else{
            return response()->json(['error'=>'Opps, something was wrong!']);
        }
    }
}
