<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail {
    
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function verifyUser() {
      return $this->hasOne('App\Models\VerifyUser');
    }

    public function notifications() {
        return $this->hasMany('App\Models\Notification'); 
    }

    public function communities() {
        return $this->belongsTo('App\Models\Community');
    }

    public static function getKarma($user_id) {
        $karma = 1;
        $threads = Thread::where('user_id', $user_id)->withCount('upvotes')->withCount('downvotes')->get();
        foreach ($threads as $thread) {
        $karma += 0.05+($thread->upvotes_count*0.025)+($thread->downvotes_count*(-0.025));
        }
        return number_format($karma, 2, ',', '.');
    }
}