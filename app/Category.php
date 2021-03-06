<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Article;

class Category extends Model
{
    protected $fillable=['title', 'slug', 'importance'];
    use Sluggable;
    //
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function articles(){
        return $this->hasMany(Article::class)->orderBy('updated_at', 'desc');
    }

    public function latestFourArticles(){
        $articles=Article::with('category', 'user')->where('category_id', $this->id)->oldest('updated_at')->take(4)->get();
        return $articles;
    }
}
