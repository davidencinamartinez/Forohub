<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Auth;

class UserCommunity extends Model {

    use HasFactory;

    protected $fillable = [
        'created_at',
        'updated_at',
        'community_id',
        'user_id',
        'subscription_type'
    ];

    protected $table = 'users_communities';

    public function communities() {
        return $this->belongsTo(Community::class, 'community_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function userCount($community_id) {
        return UserCommunity::where('community_id', $community_id)->count();
    }

    public static function JoinCommunity($community_id) {
        UserCommunity::create([
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'community_id' => $community_id,
            'user_id' => Auth::user()->id,
            'subscription_type' => 0
        ]);
    }

    public static function UnjoinCommunity($community_id, $user_id) {
        UserCommunity::where('community_id', $community_id)->where('user_id', $user_id)->delete();
    }
}
