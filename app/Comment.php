<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Helper;

class Comment extends Model
{
    use Helper;

    protected $fillable=['article_id', 'user_id', 'body', 'approved', 'approved_by'];

    public function article(){
        return $this->belongsTo(Article::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function replies(){
        return $this->hasMany(Reply::class);
    }
}
