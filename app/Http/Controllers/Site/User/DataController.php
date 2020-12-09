<?php

namespace App\Http\Controllers\Site\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reward;
use App\Models\User;
use App\Models\Community;
use App\Models\UserCommunity;
use Auth;
use DB;
use App\Models\Notification;
use Carbon\Carbon;

class DataController extends Controller {
    
	/* REWARDS */

	function getRewards() {
        
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

    /* NOTIFICATIONS */

        /* GET USER NOTIFICATIONS */

        function unreadNotifications() {
            if (Auth::user()) {
                $count = Notification::where('user_id', Auth::user()->id)
                ->where('read', false)
                ->count();
                if ($count != 0) {
                    return $count;
                }
            }
        }

        function getNotifications() {
            if (Auth::user()) {
                $notifications = Notification::where('user_id', Auth::user()->id)
                ->orderBy('id', 'desc')
                ->get();
                return $notifications;
            } 
        }

        /* READ NOTIFICATIONS */

        function readNotifications(Request $request) {
            if ($request->ajax()) {
                if (Auth::user()) {
                    Notification::where('user_id', '=', Auth::user()->id)->update(['read' => 1]);
                }
            }
        }

    /* COMMUNITIES */

        /* JOIN COMMUNITY */

        function joinCommunity(Request $request) {
            if ($request->ajax()) {
                if (Auth::user()) {
                    $community = Community::where('tag', $request->community)->select('id', 'title')->first();
                    $query = DB::table('users_communities')->where('community_id', '=', $community->id)->where('user_id', '=', Auth::user()->id)->exists();
                    if ($query) {
                        return response()->json(['response' => 'Ya estás suscrito a esta comunidad']);
                    } else {
                        UserCommunity::JoinCommunity($community->id);
                        return response()->json(['success' => '👥 Te has suscrito a '.$community->title.' 👥']);
                    }
                    
                }
            }
        }

        function unjoinCommunity(Request $request) {
            if ($request->ajax()) {
                if (Auth::user()) {
                    $community = Community::where('tag', $request->community)->select('id', 'title')->first();
                    $query = DB::table('users_communities')->where('community_id', '=', $community->id)->where('user_id', '=', Auth::user()->id)->exists();
                    if ($query) {
                        UserCommunity::UnjoinCommunity($community->id, Auth::user()->id);
                        return response()->json(['success' => '😟 Has salido de la comunidad 😟']);
                    } else {
                        return response()->json(['response' => 'Ha ocurrido un problema (Error 500)']);
                    }
                }
            }
        }

}
