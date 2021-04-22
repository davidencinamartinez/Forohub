<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserReward;
use App\Models\Notification;

class Reward extends Model {

    use HasFactory;

    public function users() {
    	return $this->belongsToMany(User::class, 'users_rewards');
    }

    public static function userHasReward() {
    	if (UserReward::userHasReward($thread_author_id, 12) == false) {
    	    UserReward::createUserReward($thread_author_id, 12);
    	    $reward = Reward::where('id', 12)->first();
    	    $data["reward_title"] = $reward->name;
    	    $data["reward_logo"] = $reward->filename;
    	    Notification::createNotification($thread_author_id, json_encode($data), "reward");
    	}
    }
    
}
