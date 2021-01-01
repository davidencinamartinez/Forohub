<?php

namespace App\Http\Controllers\Site\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reward;
use App\Models\User;
use App\Models\Community;
use App\Models\UserCommunity;
use App\Models\Thread;
use App\Models\File;
use Auth;
use DB;
use App\Models\Notification;
use Carbon\Carbon;
use Validator;

class DataController extends Controller {

    /* AVATAR */

    function updateAvatar(Request $request) {
        if (Auth::user()) {
            $messages = [

                'avatar.required' => 'Debes seleccionar un archivo',
                'avatar.image' => 'Sólo se permiten ficheros de tipo imagen',
                'avatar.mimes' => 'Extensiones válidas: jpg, png, gif, webp',
                'avatar.dimensions' => 'El fichero no cumple con las dimensiones permitidas (Min: 64x64 / Máx: 3840x2160) ',
                'avatar.max' => 'El tamaño máximo del fichero no puede superar los 4Mb (4096Kb)',
            ];

            $validator = Validator::make($request->all(), [
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|dimensions:min_width=64,min_height=64,max_width=3840,max_height=2160|max:4096'
            ], $messages);

            // IF VALIDATION OK
            if ($validator->passes()) {
                $upload = cloudinary()->upload($request->file('avatar')->getRealPath())->getSecurePath();
                $user = User::where('id', Auth::user()->id)->update(
                    [
                        'avatar' => $upload,
                        'updated_at' => Carbon::now()
                    ]
                );
                return response()->json(['success' => 'Tu avatar ha sido actualizado con éxito']);
            } else {
                return response()->json(['error' => $validator->getMessageBag()->toArray()]);
            }
        } else {
            return response()->json(['response' => 'Ha ocurrido un problema (Error 500)']);
        }
    }
    
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
                foreach ($notifications as $notification) {
                    if ($notification->type == 'mention' || $notification->type == 'thread_report') {
                        $community_id = Thread::where('id', $notification->notification)->value('community_id');
                        $notification->thread = Thread::where('id', $notification->notification)->value('title');
                        $notification->community = Community::where('id', $community_id)->value('tag');
                        if ($notification->type == 'thread_report') {
                            $notification->community_title = Community::where('id', $community_id)->value('title');
                        }
                    }
                } 
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
