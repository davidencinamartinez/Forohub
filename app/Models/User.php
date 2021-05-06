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

    public function subscriptions() {
        return $this->hasMany('App\Models\UserCommunity', 'user_id');
    }

    public function messages() {
        return $this->hasMany('App\Models\Reply', 'user_id');
    }

    public function threads() {
        return $this->hasMany('App\Models\Thread', 'user_id');
    }

    public function upvotes() {
        return $this->hasMany('App\Models\Vote', 'thread_id')->where('vote_type', 1);
    }

    public function downvotes() {
        return $this->hasMany('App\Models\Vote', 'thread_id')->where('vote_type', 0);
    }

    public function replies() {
        return $this->hasMany('App\Models\Reply', 'user_id');
    }

    public static function getKarma($user_id) {
        $karma = 1;
        $threads = Thread::where('user_id', $user_id)->withCount('upvotes')->withCount('downvotes')->get();
        foreach ($threads as $thread) {
        $karma += 0.05+($thread->upvotes_count*0.025)+($thread->downvotes_count*(-0.025));
        }
        return number_format($karma, 2, ',', '.');
    }

    public static function getUserPlacing($user_id) {
        $users = User::get('id');
        foreach ($users as $user) {
            $user->placing = User::getKarma($user->id);
        }
        $sorted = $users->sortByDesc('placing');
        return array_search($user_id, array_column($sorted->toArray(), 'id'))+1;
    }

    public static function getUserUpvotes($user_id) {
        $upvotes = Thread::where('user_id', $user_id)->withCount('upvotes')->pluck('upvotes_count');
        $total_upvotes = 0;
        foreach ($upvotes as $upvote) {
            $total_upvotes += $upvote;
        }
        return $total_upvotes;
    }

    public static function getUserDownvotes($user_id) {
        $downvotes = Thread::where('user_id', $user_id)->withCount('downvotes')->pluck('downvotes_count');
        $total_downvotes = 0;
        foreach ($downvotes as $downvote) {
            $total_downvotes += $downvote;
        }
        return $total_downvotes;
    }

    public static function getClientIPAddress($request) {
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];
        if (filter_var($client, FILTER_VALIDATE_IP)){
            $clientIp = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)){
            $clientIp = $forward;
        } else {
            $clientIp = $remote;
        }
        return $clientIp;
    }
}
