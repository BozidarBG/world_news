<?php


namespace App\Http\Controllers;

use App\Article;
use App\Category;
use Illuminate\Http\Request;
use Session;
use Log;

class CategoryController extends Controller
{
    public function __construct(){
        $this->middleware('administrator')->except(['index']);
    }

    public function index(Request $request)
    {
        $categories=Category::all();
        if($request->ajax()){
            return response()->json($categories->last());
        }
        return view('admin.categories.index')->with('categories',Category::all());
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'title'=>'required|unique:categories',
            'importance'=>'required|numeric'
        ]);

        $category=new Category();
        $category->title=$request['title'];
        $category->importance=$request['importance'];

        if($category->save()){

            return response()->json(['success']);
        }else{

            return response()->json(['error']);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title'=>'string',
            'importance'=>'numeric'
        ]);

        $category=Category::find($id);
        $category->title=$request['title'];
        $category->importance=$request['importance'];
        if($category->save()){

            return response()->json(['success'=>'Category updated successfully!']);
        }else{

            return response()->json(['error'=>'Opps, something was wrong']);
        }

    }


    public function destroy($id)
    {
        Log::warning($id);
        $category=Category::findOrFail($id);
        $article=Article::where('category_id', $id)->first();

        if($article){
            return response()->json(['articles']);
        }

        if($category->delete()){

            return response()->json(['success', $id]);
        }else{

            return response()->json(['error']);
        }

    }
}
