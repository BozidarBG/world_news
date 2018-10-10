<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Helper;


class Article extends Model
{
    //
    use Helper;
    use Sluggable;
    use SoftDeletes;
    protected $fillable=['user_id', 'category_id', 'title', 'slug', 'body', 'photo', 'draft'];
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title',
                'unique'=>true
            ]
        ];
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function approved(){
        return $this->approved ? 'Approved' : 'Unapproved';
    }

    public function approvedBy(){

        return User::whereId($this->approved_by)->first() ? User::whereId($this->approved_by)->first()->name : 'No one';
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }



}
