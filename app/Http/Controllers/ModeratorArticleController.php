<?php

namespace App\Http\Controllers;


use File;
use Illuminate\Http\Request;
use App\Category;
use App\Article;
use Session;
use Auth;
use App\Important;
use Log;


class ModeratorArticleController extends Controller
{
    public function __construct(){
        $this->middleware('moderator');
    }

    public function edit($slug)
    {
        $article=Article::withTrashed()->where('slug', $slug)->first();
        $important=Important::where('article_id', $article->id)->first();
        if($important){
            $slider=true;
        }else{
            $slider=false;
        }
        return view('admin.articles.moderator-edit')
            ->with('article', $article)

            //->with('categories', Category::all())
            ->with('slider', $slider)
            ;
    }

    public function approveArticle($id)
    {
        $article=Article::findOrFail($id);
        if($article->approved==true){
            $article->approved=false;
            $article->approved_by=false;
            $msg="Article unapproved successfully!";
        }else{
            $article->approved=true;
            $article->approved_by=Auth::id();
            $msg="Article approved successfully!";
        }

        $article->save();

        Session::flash('success', $msg);
        return redirect()->back();

    }

    public function articlePosition($id){
        //$article=Article::findOrFail($id);

        if($important=Important::where('article_id', $id)->first()){
            $important->delete();
        }else{
            $important=new Important();
            $important->article_id=$id;
            $important->type=1;
            $important->position=1;
            $important->save();
        }
        return redirect()->back();
    }


    public function destroy($slug)
    {
        $article=Article::whereSlug($slug)->first();
        $article->delete();
        Session::flash('success', 'Article sent to trash!');
        return redirect()->back();
    }



    public function kill($slug){
        $article=Article::withTrashed()->where('slug', $slug)->first();
        $path = parse_url($article->photo);
        File::delete(public_path($path['path']));
        $article->forceDelete();
        Session::flash('success', 'Article deleted for good!');
        return redirect()->back();
    }

    public function restore($slug){
        $article=Article::withTrashed()->where('slug', $slug)->first();
        $article->restore();
        Session::flash('success', 'Article is back from the trash!');
        return redirect()->back();
    }



}
