<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Auth;

class UserReward extends Model {

    use HasFactory;

    protected $table = 'users_rewards';

    protected $fillable = [
        'created_at',
        'updated_at',
        'user_id',
        'reward_id',
    ];

    public static function createUserReward($user_id, $reward_id) {
    	UserReward::create([
    	    'created_at' => Carbon::now(),
    	    'updated_at' => Carbon::now(),
    	    'user_id' => $user_id,
    	    'reward_id' => $reward_id
    	]);
    }

    public static function userHasReward($user_id, $reward_id) {
        $user_has_reward = UserReward::where('user_id', $user_id)->where('reward_id', $reward_id)->exists();
        return $user_has_reward;
    }
}
