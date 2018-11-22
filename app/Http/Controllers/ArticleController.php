<?php

namespace App\Http\Controllers;

use App\Category;
use App\Article;
use App\User;
use Illuminate\Http\Request;
use Session;


class ArticleController extends Controller
{

    //everyone can see all articles
    public function approved()
    {
        return view('admin.articles.index')
            ->with('articles', Article::with('user','category', 'approvedBy')->where('approved', 1)->orderBy('updated_at','desc')->paginate(10))
            ->with('page_name', 'Approved')
            ->with('users', User::whereIn('role_id',[3, 2, 4])->get())
            ->with('categories', Category::all())
            ;
    }

    public function unapproved()
    {
        return view('admin.articles.index')
            ->with('articles', Article::with('user','category')->where('approved', 0)->orderBy('updated_at','desc')->paginate(10))
            ->with('page_name', 'Unapproved')
            ->with('users', User::whereIn('role_id',[3, 2, 4])->get())
            ->with('categories', Category::all())
            ;
    }

    public function show($slug)
    {
        return view('admin.articles.show')->with('articles', Article::findOrFail($slug));
    }

    public function trashed(){

        return view('admin.articles.trashed')
            ->with('articles', Article::with('user','category')->onlyTrashed()->orderBy('updated_at','desc')->paginate(10))
            ->with('users', User::whereIn('role_id',[3, 2, 4])->get())
            ->with('categories', Category::all())
            ->with('page_name', 'Trashed');
    }


    public function searchTitle(Request $request){
    //title, page_name
        //dd($request->all());
        $this->validate($request, [
            'title_search'=>'required|string',
            'page_name'=>'required|string'
        ]);

        $articles=Article::where('title', 'like', '%'.$request->title_search.'%')->paginate(15);
        return view('admin.articles.index')
            ->with('articles', $articles)
            ->with('page_name', 'Search')
            ->with('users', User::whereIn('role_id',[3, 2, 4])->get())
            ->with('categories', Category::all())
            ;
    }

}