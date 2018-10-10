<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Helper;
use App\User;

class Email extends Model
{

    use Helper;
    protected $fillable=['sender', 'receiver', 'title', 'body', 'hashid', 'was_read', 'important_sender', 'important_receiver'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getUsersHashid($id){
        return User::where('id', $id)->first()->hashid ?? 'false';
    }

    public function getUsersName($id){
        return User::where('id', $id)->first()->name ?? 'No User';
    }
}
