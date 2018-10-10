<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Important extends Model
{
    //
    protected $fillable=['article_id', 'type', 'position'];

    public function article(){
        return $this->belongsTo(Article::class);
    }
}


