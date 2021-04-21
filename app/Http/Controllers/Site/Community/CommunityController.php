<?php

namespace App\Http\Controllers\Site\Community;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Community;
use App\Models\CommunityTags;
use App\Models\Thread;
use App\Models\PollVote;
use App\Models\PollOption;
use App\Models\UserCommunity;
use App\Models\Vote;
use App\Models\ReportThread;
use App\Models\Notification;
use App\Models\UserCommunityBan;
use App\Models\CommunityRules;
use Auth;
use DB;
use Redirect;
use Validator;
use Carbon\Carbon;

class CommunityController extends Controller {
    
    function getCommunity($community_tag) {
    	// UNREAD NOTIFICATIONS
            $unread_notifications = app('App\Http\Controllers\Site\User\DataController')->unreadNotifications();
        // GET COMMUNITY ID
    	   $communityId = Community::where('tag', $community_tag)->value('id');
        // GET THREADS FROM COMMUNITY
    		$threads = Thread::orderBy('created_at', 'desc')
    	    ->where('community_id', $communityId)
    	    ->with('communities')
    	    ->with('author')
    	    ->withCount('replies')
    	    ->withCount('upvotes')
    	    ->withCount('downvotes')
    	    ->paginate(4, ['*'], 'pagina');
        // GET COMMUNITY DATA
	       $community = Community::where('id', $communityId)->with('community_moderators')->with('community_rules')->withCount('threads')->first();
            $community->sub_count = UserCommunity::userCount($communityId);
            $community->index = Community::getCommunityPlacing($communityId);
        // USER ADMIN/LEADER
		if (Auth::user()) {
			foreach ($community->community_moderators as $moderator) {
				if ($moderator->user_id == Auth::user()->id && $moderator->subscription_type == 2000) {
					$community->is_mod = 'true';
				} elseif ($moderator->user_id == Auth::user()->id && $moderator->subscription_type == 5000) {
                    $community->is_leader = 'true';
                }
			}
		}
        // GET COMMUNITY TAGS
		  $tags = CommunityTags::where('community_id', $communityId)->get();

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
    		return view('layouts.desktop.templates.community.community',
    			[	'unread_notifications' => $unread_notifications,
    	            'threads' => $threads,
    	            'community' => $community,
    	            'tags' => $tags,
    			]);
		} else {
			return view('layouts.desktop.templates.community.community',
				[	'unread_notifications' => $unread_notifications,
					'community' => $community,
					'tags' => $tags,
			]);
		}
    }

    function newCommunity() {
        if (Auth::user()) {
            $unread_notifications = app('App\Http\Controllers\Site\User\DataController')->unreadNotifications();
            return view('layouts.desktop.templates.community.create')->with('unread_notifications', $unread_notifications);
        } else {
            return Redirect::to('/');
        }
    }

    function validateNewCommunity(Request $request) {
        if (Auth::user() && $request->ajax()) {
            return Community::createCommunity($request);
        } else {
            abort(404);
        }
    }

    function getCommunityReports($community_tag) {
        if (!Auth::user()) {
            abort(404);
        }
        $community = Community::where('tag', $community_tag)->first();
        if (UserCommunity::where('user_id', Auth::user()->id)
            ->where('community_id', $community->id)
            ->whereIn('subscription_type', [5000,2000])
            ->doesntExist()) {
            abort(404);
        }
        $unread_notifications = app('App\Http\Controllers\Site\User\DataController')->unreadNotifications();
        $thread_reports = Community::where('id', $community->id)->with('thread_reports')->with('thread_reports.author')->get()->pluck('thread_reports');
        $reply_reports = Thread::where('community_id', $community->id)->with('reply_reports')->with('reply_reports.author')->get();
        // REPLY REFERENCE
       $threads = Thread::where('community_id', $community->id)->with('replies')->with('replies.reports.author')->get();
        foreach ($threads as $thread) {
            $counter = 1;
            foreach ($thread->replies as $reply) {
                foreach($reply->reports as $report) {
                    $report->page = ceil($counter/10);
                    $report->thread_id = $thread->id;
                }
                $counter+=1;
            }
        }
        return view('layouts.desktop.templates.community.reports',
            [   'unread_notifications' => $unread_notifications,
                'community' => $community,
                'thread_reports' => $thread_reports->first()->sortByDesc('created_at')->sortBy('solved'),
                'reply_reports' => $threads->pluck('replies.*.reports', 'thread_id')->collapse()->collapse()->sortByDesc('created_at')->sortBy('solved')
        ]);
    }

    function getAffiliates($community_tag, $character = null) {
        $unread_notifications = app('App\Http\Controllers\Site\User\DataController')->unreadNotifications();
        $community = Community::where('tag', $community_tag)->first();
        $affiliates = Community::getAffiliates($community->id, $character);
        if (!Auth::check()) {
            abort(404);
        } elseif (UserCommunity::where('community_id', $community->id)->where('user_id', Auth::user()->id)->where('subscription_type', 5000)->doesntExist()) {
            abort(404);
        }
        return view('layouts.desktop.templates.community.affiliates.affiliates',
            [   'unread_notifications' => $unread_notifications,
                'community' => $community,
                'affiliates' => $affiliates,
                'character' => $character
            ]);
    }

    function rankAsAffiliate(Request $request) {
        $community = Community::where('tag', $request->community_tag)->first();
        if (!UserCommunity::isUserLeader(Auth::user()->id, $community->id)) {
            abort(404);
        }
        UserCommunity::where('user_id', $request->user_id)->where('community_id', $community->id)->update(['subscription_type' => 0]);
        // Notification JSON
        $data["community_tag"] = $community->tag;
        $data["community_title"] = $community->title;
        $data["community_logo"] = $community->logo;
        $data["user_rank"] = "Afiliado";
        Notification::createNotification($request->user_id, json_encode($data), "community_rank");
        return back();
    }

    function rankAsModerator(Request $request) {
        $community = Community::where('tag', $request->community_tag)->first();
        if (!UserCommunity::isUserLeader(Auth::user()->id, $community->id)) {
            abort(404);
        }
        UserCommunity::where('user_id', $request->user_id)->where('community_id', $community->id)->update(['subscription_type' => 2000]);
        // Notification JSON
        $data["community_tag"] = $community->tag;
        $data["community_title"] = $community->title;
        $data["community_logo"] = $community->logo;
        $data["user_rank"] = "Moderador";
        Notification::createNotification($request->user_id, json_encode($data), "community_rank");
        return back();
    }

    function rankAsLeader(Request $request) {
        // Variables
        $community = Community::where('tag', $request->community_tag)->first();
        if (!UserCommunity::isUserLeader(Auth::user()->id, $community->id)) {
            abort(404);
        }
        $leader = UserCommunity::where('community_id', $community->id)->where('subscription_type', 5000)->first();
        // Queries
        UserCommunity::where('community_id', $community->id)->where('user_id', $leader->user_id)->update(['subscription_type' => 0]);
        UserCommunity::where('user_id', $request->user_id)->where('community_id', $community->id)->update(['subscription_type' => 5000]);
        // Notifications
            // Notification JSON
            $data["community_tag"] = $community->tag;
            $data["community_title"] = $community->title;
            $data["community_logo"] = $community->logo;
            $data["user_rank"] = "Líder";
            Notification::createNotification($request->user_id, json_encode($data), "community_rank");
            // Notification JSON
            $data["community_tag"] = $community->tag;
            $data["community_title"] = $community->title;
            $data["community_logo"] = $community->logo;
            $data["user_rank"] = "Afiliado";
            Notification::createNotification($leader->user_id, json_encode($data), "community_rank");
        // Response
        return redirect()->route('index');
    }

    function banUserFromCommunity(Request $request) {
        $community = Community::where('tag', $request->community_tag)->first();
        if (!UserCommunity::isUserLeader(Auth::user()->id, $community->id)) {
            abort(404);
        }
        UserCommunityBan::banUser($request->user_id, $community->id);
        return back();
    }

    /* UPDATES */

        /* TITLE UPDATE */

        function titleUpdate(Request $request) {
            if (Auth::check()) {
                $messages = [
                    'title.required' => 'No se permiten campos vacíos',
                    'title.min' => 'El título de la comunidad debe contener mínimo 3 carácteres',
                    'title.max' => 'El título de la comunidad debe contener máximo 50 carácteres',
                    'community.required' => 'Esta comunidad no existe o no está disponible',
                    'community.exists' => 'Esta comunidad no existe o no está disponible',
                ];
                $validator = Validator::make($request->all(), [
                    'title' => 'required|min:3|max:50',
                    'community' => 'required|exists:communities,tag'
                ], $messages);
                if (!$validator->passes()) {
                    return response()->json(['error' => $validator->getMessageBag()->first()]);
                }
                $community_id = Community::where('tag', $request->community)->first()->value('id');
                if (UserCommunity::isUserLeader(Auth::user()->id, $community_id)) {
                    Community::where('id', $community_id)->update(['title' => $request->title]);
                } else {
                    return response()->json(['error' => 'Ha ocurrido un problema (Error 500)']);
                }
            }
        }

        /* DESCRIPTION UPDATE */

        function descriptionUpdate(Request $request) {
            if (Auth::check()) {
                $messages = [
                    'description.required' => 'No se permiten campos vacíos',
                    'description.min' => 'El título de la comunidad debe contener mínimo 3 carácteres',
                    'description.max' => 'El título de la comunidad debe contener máximo 50 carácteres',
                    'community.required' => 'Esta comunidad no existe o no está disponible',
                    'community.exists' => 'Esta comunidad no existe o no está disponible',
                ];
                $validator = Validator::make($request->all(), [
                    'description' => 'required|min:3|max:500',
                    'community' => 'required|exists:communities,tag'
                ], $messages);
                if (!$validator->passes()) {
                    return response()->json(['error' => $validator->getMessageBag()->first()]);
                }
                $community_id = Community::where('tag', $request->community)->first()->value('id');
                if (UserCommunity::isUserLeader(Auth::user()->id, $community_id)) {
                    Community::where('id', $community_id)->update(['description' => $request->description]);
                } else {
                    return response()->json(['error' => 'Ha ocurrido un problema (Error 500)']);
                }
            }
        }


        /* LOGO UPDATE */

        function logoUpdate(Request $request) {
            if (Auth::check()) {
                $messages = [
                    'logo.required' => 'Debes seleccionar un archivo',
                    'logo.image' => 'Sólo se permiten ficheros de tipo imagen',
                    'logo.mimes' => 'Extensiones válidas: .jpg, .png, .webp',
                    'logo.dimensions' => 'El fichero no cumple con las dimensiones permitidas (Min: 64x64 / Máx: 2048x2048)',
                    'logo.max' => 'El tamaño máximo del fichero no puede superar los 2Mb (2048Kb)',
                    'community.required' => 'Esta comunidad no existe o no está disponible',
                    'community.exists' => 'Esta comunidad no existe o no está disponible',
                ];
                $validator = Validator::make($request->all(), [
                   'logo' => 'required|image|mimes:jpeg,png,jpg,webp|dimensions:min_width=64,min_height=64,max_width=2048,max_height=2048|max:2048',
                   'community' => 'required|exists:communities,tag'
                ], $messages);
                if (!$validator->passes()) {
                    return response()->json(['error' => $validator->getMessageBag()->first()]);
                }
                $community_id = Community::where('tag', $request->community)->value('id');
                if (UserCommunity::isUserLeader(Auth::user()->id, $community_id)) {
                    $upload = cloudinary()->upload($request->file('logo')->getRealPath())->getSecurePath();
                    Community::where('id', $community_id)->update(['logo' => $upload]);
                } else {
                    return response()->json(['error' => 'Ha ocurrido un problema (Error 500)']);
                }
            }
        }

        /* BACKGROUND UPDATE */

        function backgroundUpdate(Request $request) {
            if (Auth::check()) {
                $messages = [
                    'background.required' => 'Debes seleccionar un archivo',
                    'background.image' => 'Sólo se permiten ficheros de tipo imagen',
                    'background.mimes' => 'Extensiones válidas: .jpg, .png, .webp',
                    'background.dimensions' => 'El fichero no cumple con las dimensiones permitidas (Min: 1366x768 / Máx: 7680x4096)',
                    'background.max' => 'El tamaño máximo del fichero no puede superar los 4Mb (4096Kb)',
                    'community.required' => 'Esta comunidad no existe o no está disponible',
                    'community.exists' => 'Esta comunidad no existe o no está disponible',
                ];
                $validator = Validator::make($request->all(), [
                   'background' => 'required|image|mimes:jpeg,png,jpg,webp|dimensions:min_width=1366,min_height=768,max_width=7680,max_height=4320|max:4096',
                   'community' => 'required|exists:communities,tag'
                ], $messages);
                if (!$validator->passes()) {
                    return response()->json(['error' => $validator->getMessageBag()->first()]);
                }
                $community_id = Community::where('tag', $request->community)->value('id');
                if (UserCommunity::isUserLeader(Auth::user()->id, $community_id)) {
                    $upload = cloudinary()->upload($request->file('background')->getRealPath())->getSecurePath();
                    Community::where('id', $community_id)->update(['background' => $upload]);
                } else {
                    return response()->json(['error' => 'Ha ocurrido un problema (Error 500)']);
                }
            }
        }

        /* ADD COMMUNITY RULE */

        function addCommunityRule(Request $request) {
            if (Auth::check()) {
                $request->ruleTitle = strip_tags($request->ruleTitle);
                $request->ruleDescription = strip_tags($request->ruleDescription);
                $messages = [
                    'ruleTitle.required' => 'Campo vacío (Título)',
                    'ruleTitle.min' => 'El título debe contener mínimo 3 carácteres',
                    'ruleTitle.max' => 'El título excede la longitud máxima permitida (60 carácteres)',
                    'ruleDescription.required' => 'Campo vacío (Descripción)',
                    'ruleDescription.min' => 'La descripción debe contener mínimo 3 carácteres',
                    'ruleDescription.max' => 'La descripción excede la longitud máxima permitida (300 carácteres)',
                    'community.required' => 'Esta comunidad no existe o no está disponible',
                    'community.exists' => 'Esta comunidad no existe o no está disponible',
                ];
                $validator = Validator::make($request->all(), [
                   'ruleTitle' => 'required|min:3|max:60',
                   'ruleDescription' => 'required|min:3|max:300',
                   'community' => 'required|exists:communities,tag'
                ], $messages);
                if (!$validator->passes()) {
                    return response()->json(['error' => $validator->getMessageBag()->first()]);
                }
                $community_id = Community::where('tag', $request->community)->value('id');
                if (UserCommunity::isUserLeader(Auth::user()->id, $community_id)) {
                    CommunityRules::create([
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        'community_id' => $community_id,
                        'rule' => $request->ruleTitle,
                        'rule_description' => $request->ruleDescription,
                    ]);
                } else {
                    return response()->json(['error' => 'Ha ocurrido un problema (Error 500)']);
                }
            }
        }

        /* EDIT COMMUNITY RULE */

        function editCommunityRule(Request $request) {
            if (Auth::check()) {
                $community_id = Community::where('tag', $request->community)->value('id');
                if (CommunityRules::where('id', $request->ruleId)->where('community_id', $community_id)->doesntExist()) {
                    return response()->json(['error' => 'Ha ocurrido un problema (Error 500)']);
                }
                $request->ruleTitle = strip_tags($request->ruleTitle);
                $request->ruleDescription = strip_tags($request->ruleDescription);
                $messages = [
                    'ruleId.required' => 'Ha ocurrido un problema (Error 500)',
                    'ruleId.exists' => 'Ha ocurrido un problema (Error 500)',
                    'ruleTitle.required' => 'Campo vacío (Título)',
                    'ruleTitle.min' => 'El título debe contener mínimo 3 carácteres',
                    'ruleTitle.max' => 'El título excede la longitud máxima permitida (60 carácteres)',
                    'ruleDescription.required' => 'Campo vacío (Descripción)',
                    'ruleDescription.min' => 'La descripción debe contener mínimo 3 carácteres',
                    'ruleDescription.max' => 'La descripción excede la longitud máxima permitida (300 carácteres)',
                    'community.required' => 'Esta comunidad no existe o no está disponible',
                    'community.exists' => 'Esta comunidad no existe o no está disponible',
                ];
                $validator = Validator::make($request->all(), [
                    'ruleId' => 'required|exists:communities_rules,id',
                    'ruleTitle' => 'required|min:3|max:60',
                    'ruleDescription' => 'required|min:3|max:300',
                    'community' => 'required|exists:communities,tag'
                ], $messages);
                if (!$validator->passes()) {
                    return response()->json(['error' => $validator->getMessageBag()->first()]);
                }
                if (UserCommunity::isUserLeader(Auth::user()->id, $community_id)) {
                    CommunityRules::where('id', $request->ruleId)
                    ->where('community_id', $community_id)
                    ->update([
                        'rule' => $request->ruleTitle,
                        'rule_description' => $request->ruleDescription,
                    ]);
                } else {
                    return response()->json(['error' => 'Ha ocurrido un problema (Error 500)']);
                }
            }
        }

        /* DELETE COMMUNITY RULE */

        function deleteCommunityRule(Request $request) {
            if (Auth::check()) {
                $community_id = Community::where('tag', $request->community)->value('id');
                if (CommunityRules::where('id', $request->ruleId)->where('community_id', $community_id)->doesntExist()) {
                    return response()->json(['error' => 'Ha ocurrido un problema (Error 500)']);
                }
                $messages = [
                    'ruleId.required' => 'Ha ocurrido un problema (Error 500)',
                    'ruleId.exists' => 'Ha ocurrido un problema (Error 500)',
                    'community.required' => 'Esta comunidad no existe o no está disponible',
                    'community.exists' => 'Esta comunidad no existe o no está disponible',
                ];
                $validator = Validator::make($request->all(), [
                    'ruleId' => 'required|exists:communities_rules,id',
                    'community' => 'required|exists:communities,tag'
                ], $messages);
                if (!$validator->passes()) {
                    return response()->json(['error' => $validator->getMessageBag()->first()]);
                }
                if (UserCommunity::isUserLeader(Auth::user()->id, $community_id)) {
                    CommunityRules::where('id', $request->ruleId)->delete();
                } else {
                    return response()->json(['error' => 'Ha ocurrido un problema (Error 500)']);
                }
            }
        }
}
