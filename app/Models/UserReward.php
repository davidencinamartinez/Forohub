<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Auth;
use App\Models\Notification;

class UserReward extends Model {

    use HasFactory;

    protected $table = 'users_rewards';

    protected $fillable = [
        'created_at',
        'updated_at',
        'user_id',
        'reward_id',
    ];

    public function reward() {
        return $this->belongsTo('App\Models\Reward');
    }

    public static function createUserReward($user_id, $reward_id) {
        // Create User Reward
    	UserReward::create([
    	    'created_at' => Carbon::now(),
    	    'updated_at' => Carbon::now(),
    	    'user_id' => $user_id,
    	    'reward_id' => $reward_id
    	]);
        // Create Notification
        $reward = Reward::where('id', $reward_id)->first();
        $data["reward_title"] = $reward->name;
        $data["reward_logo"] = $reward->filename;
        Notification::createNotification($user_id, json_encode($data), "reward");
    }

    public static function userHasReward($user_id, $reward_id) {
        $user_has_reward = UserReward::where('user_id', $user_id)->where('reward_id', $reward_id)->exists();
        return $user_has_reward;
    }

    public static function deleteUserReward($user_id, $reward_id) {
        $user_has_reward = UserReward::where('user_id', $user_id)->where('reward_id', $reward_id)->exists();
        return $user_has_reward;
    }
     
}
