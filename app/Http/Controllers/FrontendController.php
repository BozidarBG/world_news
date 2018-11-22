<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Article;
use Illuminate\Support\Facades\Cache;

class FrontendController extends Controller
{

    public function index()
    {
        $arr=[];

        $categories=Cache::remember('categories', 1440, function(){
            return Category::select('id','importance', 'title', 'slug')->orderBy('importance')->get();
        });

        for($i=0; $i<count($categories); $i++){

            $data=Cache::remember("data[$i]", 15, function() use ($categories, $i){
                return Article::with('user')->where('category_id', $categories[$i]['id'])->where('approved', 1)->oldest('updated_at')->take(4)->get()->toArray();;
            });

            $newarr=['category'=>$categories[$i], 'articles'=>$data ];
            array_push($arr, $newarr);
        }
        //dd($arr);

        return view('start')
            ->with('data',$arr)
            ;
    }


    public function show($category_slug, $article_slug)
    {
        $article=Article::with(['user', 'comments'=>function($query){
            $query->where('approved', 1)->get();
        },'comments.user', 'comments.replies.user'])->where('slug', $article_slug)->first();
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

        $articles=Article::with('user', 'comments.replies')->where('approved', 1)
            ->where('title', 'like', '%'.request('query').'%')
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('search')->with('articles', $articles)
            ->with('query', request('query'));
    }


    public function byCategory($slug){



        $category=Category::where('slug',$slug)->first();

        if($category==null){
            return redirect()->back();
        }
        //$category=Category::where('slug', $slug)->first();


        $articles=Article::with('user', 'category' , 'comments')->where('category_id', $category->id)
            ->where('approved', 1)
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('categories')
            ->with('articles',$articles)
            ->with('category_title', $category->title);
    }




}
