<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;
use App\Models\Notification;
use App\Models\Community;

class UserCommunityBan extends Model {
    use HasFactory;

    protected $fillable = [
        'created_at',
        'updated_at',
        'community_id',
        'user_id'
    ];

    protected $table = 'users_communities_bans';

    public static function isUserBanned($user_id, $community_id) {
    	if (UserCommunityBan::where('community_id', $community_id)
    		->where('user_id', $user_id)
    		->exists()) {
    		return true;
    	}
    	return false;
    }

    public static function banUser($user_id, $community_id) {
    	if (UserCommunityBan::isUserBanned($user_id, $community_id)) {
    		abort(404);
    	}
    	if ($user_id == Auth::user()->id) {
    		abort(404);
    	}
    	UserCommunityBan::create([
    		'created_at' => Carbon::now(),
    		'updated_at' => Carbon::now(),
    		'community_id' => $community_id,
    		'user_id' => $user_id,
    	]);
    	UserCommunity::where('community_id', $community_id)->where('user_id', $user_id)->delete();
        // Notification JSON
        $community = Community::where('id', $community_id)->first();
        $data["community_tag"] = $community->tag;
        $data["community_title"] = $community->title;
        $data["community_logo"] = $community->logo;
        Notification::createNotification($user_id, json_encode($data), "community_ban");
    }
}
