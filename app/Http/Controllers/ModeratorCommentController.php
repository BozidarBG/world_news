<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Article;
use App\Reply;
use Session;
use Auth;
use Log;

class ModeratorCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('moderator')->except(['store']);;
    }


    public function unapproved()
    {
        return view('admin.comments.index')
            ->with('items', Comment::where('approved', 0)->orderBy('created_at', 'desc')->paginate(20))
            ->with('page_name', 'Unapproved comments')
            ;
    }

    public function approved()
    {
        return view('admin.comments.index')
            ->with('items', Comment::where('approved', 1)->orderBy('created_at', 'desc')->paginate(20))
            ->with('page_name', 'Approved comments');
    }



    public function store(Request $request)
    {
        Log::warning(Article::where('slug', $request->name)->first()->id);
        if(!$article_id=Article::where('slug', $request->name)->first()->id){
            return redirect()->back();
        }
        $this->validate($request, [
            'body'=>'required|string|min:2|max:1000',

        ]);

        $comment=new Comment();
        $comment->article_id=$article_id;
        $comment->user_id=Auth::id();
        $comment->body=$request->body;
        $comment->save();
        Session::flash('success', 'Comment sent to approval successfully!');
        return redirect()->back();

    }

    public function update(Request $request)
    {

        $this->validate($request, [
            'id'=>'numeric'
        ]);

        $comment=Comment::find($request->id);
        if($comment->approved){
            $comment->approved=false;
            $comment->approved_by=false;
        }else{
            $comment->approved=true;
            $comment->approved_by=Auth::id();
        }

        if($comment->save()){

            return response()->json(['success'=>'Comment updated successfully!','id'=>$request->id]);
        }else{

            return response()->json(['error'=>'Opps, something was wrong!']);
        }
    }

//request contains comment id
    public function destroy(Request $request)
    {

        $comment=Comment::findOrFail($request->id);

        //delete all replies for this comment, if comment was approved, replied to and then deleted
        $repliesForThisComment=Reply::where('comment_id', $request->id)->get()  ? Reply::where('comment_id', $request->id)->get() : null ;

        if(!$repliesForThisComment->isEmpty()){
            foreach($repliesForThisComment as $reply){
               $reply->delete();
            }

        }

        if($comment->delete()){
            return response()->json(['success'=>'Comment deleted successfully!','id'=>$request->id]);
        }else{
            return response()->json(['error'=>'Opps, something was wrong!']);
        }


    }

}
