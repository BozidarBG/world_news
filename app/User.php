<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Email;
use Log;
use Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hashid', 'name','role_id', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function articles(){
        return $this->hasMany(Article::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function replies(){
        return $this->hasMany(Reply::class);
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function emails(){
        return $this->hasMany(Email::class);
    }

    public function showUnreadEmails(){
        $unread_emails=Email::where([
                ['receiver', Auth::id()],
                ['was_read', 0],
                ['trash_receiver', 0]
            ]
        )->get();

        return $unread_emails->count();
    }

    public function isAdministrator(){
        return $this->role->name === 'administrator' ? true : false;
    }

    public function isModerator(){
        return $this->role->name === 'moderator'? true : false;
    }

    public function isJournalist()
    {
        return $this->role->name === 'journalist' ? true : false;
    }

    public function isWorker(){
        return ($this->role->name=== 'journalist' || $this->role->name==='moderator' || $this->role->name==='administrator') ? true : false;
    }
}
