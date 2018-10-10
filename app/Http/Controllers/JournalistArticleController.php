<?php

namespace App\Http\Controllers;


use File;
use Illuminate\Http\Request;
use App\Category;
use App\Article;
//use Illuminate\Support\Facades\Auth;
use Session;
use Auth;


class JournalistArticleController extends Controller
{
    public function __construct(){
        $this->middleware('journalist');
    }


    public function myArticles()
    {
        return view('admin.articles.my-articles')
            ->with('approved_articles', Article::where('user_id', Auth::id())
                ->where('approved', 1)
                ->orderBy('created_at', 'desc')
                ->paginate(10))
            ->with('unapproved_articles', Article::where('user_id', Auth::id())
                ->where('approved', 0)
                ->where('draft', 0)
                ->get())
            ->with('drafts', Article::where('user_id', Auth::id())
                ->where('approved', 0)
                ->where('draft', 1)
                ->get());
    }


    public function create()
    {
        //if categories don't exist, we can't make an article
        $categories=Category::all();

        if($categories->count()==0){
            Session::flash('info', 'You need to create categories first');
            return redirect()->back();
        }

        return view('admin.articles.create')->with('categories',$categories);
    }


    public function store(Request $request)
    {

        $this->validate($request, [
            'title'=>'required|max:255',
            'photo'=>'required|image',
            'body'=>'required',
            'category'=>'required'
        ]);

        $photo=$request->photo;
        $photo_new_name=time().$photo->getClientOriginalName();
        $photo->move('uploads/articles', $photo_new_name);
        $draft=null;
        if($request->has('send')){
            $draft=0;
        }elseif($request->has('save')){
            $draft=1;
        }else{
            return;
        }

        $article=Article::create([
            'title'=>$request->title,
            'photo'=>'uploads/articles/'.$photo_new_name,
            'body'=>$request->body,
            'category_id'=>$request->category,
            'draft'=>$draft,
            'user_id'=>Auth::id()

        ]);


        Session::flash('success', 'Article created successfully!');
        return redirect()->back();

    }


    public function edit($slug)
    {
        $article=Article::withTrashed()->where('slug',$slug)->first();;
        if($article->user_id !==Auth::id()){
            Session::flash('error', 'You can only edit your own articles');
            return redirect()->back();
        }

        if($article->approved ===1){
            Session::flash('error', 'You can\'t edit approved articles');
            return redirect()->back();
        }

        return view('admin.articles.edit')->with('article', $article)->with('categories', Category::all());
    }


    public function update(Request $request, $slug)
    {

        $this->validate($request, [
            'title'=>'required|max:255',
            'photo'=>'image',
            'body'=>'required',
            'category'=>'required'

        ]);

        $article=Article::withTrashed()->where('slug',$slug)->first();

        if($request->hasFile('photo')) {
            unlink($article->photo);
            $path = parse_url($article->photo);
            File::delete(public_path($path['path']));
            $photo = $request->photo;
            $photo_new_name = time() . $photo->getClientOriginalName();
            $photo->move('uploads/articles', $photo_new_name);
            $article->photo='uploads/articles/'.$photo_new_name;
        }
        $draft=null;
        if($request->has('send')){
            $draft=0;
        }elseif($request->has('save')){
            $draft=1;
        }else{
            return;
        }
        $article->update([
            'title'=>$request->title,
            'body'=>$request->body,
            'category_id'=>$request->category,
            'draft'=>$draft,

        ]);

        Session::flash('success', 'Article updated successfully!');
        return redirect()->back();
    }


    public function destroy($slug)
    {

        $article=Article::where('slug',$slug)->first();
        if($article->user_id !==Auth::id()){
            Session::flash('error', 'You can only send to trash your own articles');
            return redirect()->back();
        }

        if($article->approved !=0){
            Session::flash('error', 'You can\'t delete approved articles');
            return redirect()->back();
        }


        $article->delete();
        Session::flash('success', 'Article sent to trash!');
        return redirect()->back();
    }


    public function kill($slug){
        $article=Article::withTrashed()->where('slug', $slug)->first();

        if($article->user_id !==Auth::id()){
            Session::flash('error', 'You can only permanently delete your own articles');
            return redirect()->back();
        }

        if($article->approved !=0){
            Session::flash('error', 'You can\'t delete approved articles');
            return redirect()->back();
        }

        $path = parse_url($article->photo);
        File::delete(public_path($path['path']));
        $article->forceDelete();
        Session::flash('success', 'Article deleted for good!');
        return redirect()->back();
    }

    public function restore($slug){
        $article=Article::withTrashed()->where('slug', $slug)->first();


        if($article->user_id !==Auth::id()){
            Session::flash('error', "{$article->user_id} {Auth::id()}You can only restore your own articles!");
            return redirect()->back();
        }

        $article->restore();
        Session::flash('success', 'Article is back from the trash!');
        return redirect()->back();
    }

}

