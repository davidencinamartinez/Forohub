<?php

namespace App\Http\Controllers\Site\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reward;
use App\Models\UserReward;
use App\Models\User;
use App\Models\Community;
use App\Models\UserCommunity;
use App\Models\UserCommunityBan;
use App\Models\Thread;
use App\Models\File;
use Auth;
use DB;
use App\Models\Notification;
use Carbon\Carbon;
use Validator;
use App\Models\Vote;
use App\Models\PollVote;
use App\Models\PollOption;

class DataController extends Controller {

    /* GET USER */

    function getUser($user) {
        $unread_notifications = app('App\Http\Controllers\Site\User\DataController')->unreadNotifications();
        if (User::where('name', strtolower($user))->doesntExist()) {
            abort(404);
        }
        $data = User::where('name', strtolower($user))->select('id','name','created_at','about','avatar')->withCount('messages')->withCount('threads')->first();
        $user_rewards = UserReward::where('user_id', $data->id)->select('reward_id')->with('reward:id,name,text,filename')->take(5)->get();
        $data->karma = User::getKarma($data->id);
        $data->upvotes = User::getUserUpvotes($data->id);
        $data->downvotes = User::getUserDownvotes($data->id);
        $data->placing = User::getUserPlacing($data->id);
        $data->communities = UserCommunity::where('user_id', $data->id)->whereIn('subscription_type', [2000,5000])->get('community_id');
        $threads = Thread::orderBy('created_at', 'desc')
        ->where('user_id', $data->id)
        ->with('communities')
        ->with('author')
        ->withCount('replies')
        ->withCount('upvotes')
        ->withCount('downvotes')
        ->paginate(10, ['*'], 'pagina');
        if ($threads) {
            foreach ($threads as $thread) {
                if (Auth::user() and $thread->votes->isNotEmpty()) {
                    if (Vote::where('user_id', '=', Auth::user()->id)->where('thread_id', '=', $thread->id)->where('vote_type', '=', 1)->exists()) {
                        $thread->user_has_voted = 'true';
                        $thread->user_vote_type = 1;
                    } 
                    if (Vote::where('user_id', '=', Auth::user()->id)->where('thread_id', '=', $thread->id)->where('vote_type', '=', 0)->exists()) {
                        $thread->user_has_voted = 'true';
                        $thread->user_vote_type = 0;
                    }
                } 
                else {
                    $thread->user_has_voted = 'false';              
                }
            }
            
            foreach ($threads as $thread) {
                if (Auth::user()) {
                    if (DB::table('users_communities')->where('community_id', '=', $thread->communities->id)->where('user_id', '=', Auth::user()->id)->exists()) {
                            $thread->user_joined_community = 'true';
                    } else {
                        $thread->user_joined_community = 'false';
                    }
                }
            }

            foreach ($threads as $thread) {
                if ($thread->body == "IS_POLL") {
                    $poll_total_votes = PollVote::getCountVotes($thread->id);
                    $poll_options = PollOption::where('thread_id', $thread->id)->withCount('votes')->get();
                    foreach ($poll_options as $option) {
                        if ($poll_total_votes != 0) {
                            $thread->total_votes = $poll_total_votes;
                            $thread->poll_options = $poll_options;
                            foreach ($thread->poll_options as $option) {
                                $option->percentage = round(($option->votes_count/$poll_total_votes)*100, 1);
                            }
                        } else {
                            $thread->total_votes = 0;
                            $thread->poll_options = $poll_options;
                            foreach ($thread->poll_options as $option) {
                                $option->percentage = 0;
                            }
                        }
                    }
                }
            }
        }
        return view('layouts.desktop.templates.user.profile',
            [   'unread_notifications' => $unread_notifications,
                'data' => $data,
                'rewards' => $user_rewards,
                'threads' => $threads
        ]);
    }

    /* AVATAR */

    function updateAvatar(Request $request) {
        if (Auth::user() && $request->ajax()) {
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
            abort(404);
        }
    }
    
	/* REWARDS */

	function getRewards(Request $request) {
        if (Auth::user()) {
            if ($request->ajax()) {
                $rewards = Reward::get();
                foreach ($rewards as $reward) {
                    if (DB::table('users_rewards')->where('reward_id', '=', $reward->id)->where('user_id', '=', Auth::user()->id)->exists()) {
    					$reward->user_has_reward = 'true';
                    } else {
    					$reward->user_has_reward = 'false';
                    }
                }  
                return $rewards;
            } else {
                abort(404);
            }
        } else {
            abort(404);
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

        function getNotifications(Request $request) {
            if (Auth::user()) {
                if ($request->ajax()) {
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
                        if ($notification->type == "community_rank") {
                            $data = json_encode($notification->notification);
                            $data = json_decode($data);
                            $notification->community_tag = $data;
                        }
                    } 
                    return $notifications;
                } else {
                    abort(404);
                }
            } else {
                abort(404);
            }
        }

        /* READ NOTIFICATIONS */

        function readNotifications(Request $request) {
            if ($request->ajax()) {
                if (Auth::user()) {
                    Notification::where('user_id', '=', Auth::user()->id)->update(['read' => 1]);
                } else {
                    abort(404);
                }
            } else {
                abort(404);
            }
        }

    /* COMMUNITIES */

        /* JOIN COMMUNITY */

        function joinCommunity(Request $request) {
            if (Auth::user()) {
                if ($request->ajax()) {
                    $community = Community::where('tag', $request->community)->select('id', 'title')->first();
                    $query = DB::table('users_communities')->where('community_id', '=', $community->id)->where('user_id', '=', Auth::user()->id)->exists();
                    if ($query) {
                        return response()->json(['response' => 'Ya estás suscrito a esta comunidad']);
                    }
                    if (UserCommunityBan::isUserBanned(Auth::user()->id, $community->id)) {
                        return response()->json(['response' => '⛔ Estás baneado de esta comunidad ⛔']);
                    }
                    UserCommunity::JoinCommunity($community->id);
                    return response()->json(['success' => '👥 Te has suscrito a '.$community->title.' 👥']);
                } else {
                    abort(404);
                }
            } else {
                abort(404);
            }
        }

        function unjoinCommunity(Request $request) {
            if ($request->ajax() && Auth::user()) {
                return UserCommunity::UnjoinCommunity($request);
            } else {
                abort(404);
            }
        }
            
        function isLoged() {
            if (Auth::check()) {
                return response()->json(['on' => 'Is Online']);
            } else {
                return response()->json(['off' => 'Is Offline']);
            }
        }

}
