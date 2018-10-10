<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Article;

class FrontendController extends Controller
{

    public function index()
    {
        return view('start');
    }


    public function show($category_slug, $article_slug)
    {
        $article=Article::where('slug', $article_slug)->first();
        if(!$article){
            return redirect()->back();
        }
        $article->hits++;
        $article->save();


        return view('show')
            ->with('article', $article);

    }

    public function search(Request $request){

        $this->validate($request, [
            'query'=>'required|string'
        ]);

        $articles=Article::where('approved', 1)
            ->where('title', 'like', '%'.request('query').'%')
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('search')->with('articles', $articles)
            ->with('query', request('query'));
    }


    public function byCategory($slug){

        if(Category::where('slug',$slug)->first()==null){
            return redirect()->back();
        }
        $category=Category::where('slug', $slug)->first();


        $articles=Article::where('category_id', $category->id)
            ->where('approved', 1)
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('categories')
            ->with('articles',$articles)
            ->with('category_title', $category->title);
    }




}
