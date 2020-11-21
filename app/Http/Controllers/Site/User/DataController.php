<?php

namespace App\Http\Controllers\Site\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reward;
use App\Models\User;
use Auth;
use DB;

class DataController extends Controller {
    
	/* GET USER REWARDS */

	function rewards() {
        
        $rewards = Reward::get();

        if (Auth::user()) {
            foreach ($rewards as $reward) {
                if (DB::table('users_rewards')->where('reward_id', '=', $reward->id)->where('user_id', '=', Auth::user()->id)->exists()) {
					$reward->user_has_reward = 'true';
                } else {
					$reward->user_has_reward = 'false';
                }
            }  
            return $rewards;
        }
    }

}
