<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Helper;

class Reply extends Model
{
    //
    use Helper;

    protected $fillable=['comment_id', 'user_id', 'body'];

    public function comment(){
        return $this->belongsTo(Comment::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }


}
