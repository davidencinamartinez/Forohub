<?php

namespace App\Http\Controllers\Site\Thread;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reply;
use App\Models\Notification;
use App\Models\UserReward;
use App\Models\UserCommunity;
use App\Models\UserCommunityBan;
use App\Models\Thread;
use App\Models\Community;
use App\Models\User;
use App\Models\Vote;
use App\Models\ThreadTags;
use App\Models\PollOption;
use App\Models\PollVote;
use DB;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Validator;
use Redirect;

class ThreadController extends Controller {

	function getCommunityTag(Request $request, $tag) {
		if (Auth::user() && $request->ajax()) {
			$nonAllowedCommunities = UserCommunityBan::where('user_id', Auth::user()->id)->pluck('community_id');
			$communities = Community::whereNotIn('id', $nonAllowedCommunities)
			->where('tag', 'like', '%'.$tag.'%')
			->take(5)
			->select('id', 'title', 'tag', 'logo', 'description')
			->get();
			foreach ($communities as $community) {
				$community->user_count = UserCommunity::userCount($community->id);
	    	}
			return $communities;
		} else {
			abort(404);
		}
	}

	function newThread() {
		if (Auth::user()) {
			$unread_notifications = app('App\Http\Controllers\Site\User\DataController')->unreadNotifications();
			return view('layouts.desktop.templates.thread.create')->with('unread_notifications', $unread_notifications);
		} else {
			return Redirect::to('/');
		}
	}

	public function getThreadData($community_tag, $thread_id) {

		$unread_notifications = app('App\Http\Controllers\Site\User\DataController')->unreadNotifications();

		$community_id = Community::where('tag', $community_tag)->value('id');

		if (Thread::where('id', $thread_id)->where('community_id', $community_id)->doesntExist()) {
			abort(404);
		}

		$thread = Thread::orderBy('created_at', 'desc')
		->where('community_id', $community_id)
		->where('id', $thread_id)
        ->with('communities')
        ->with('author')
        ->withCount('replies')
        ->withCount('upvotes')
        ->withCount('downvotes')
		->first();

		$thread_replies = Reply::orderBy('created_at', 'asc')
		->where('thread_id', $thread_id)
		->with('user')
		->paginate(10, ['*'], 'pagina');

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

		if ($community_id == null || $thread == null) {
			abort(404);
		} else {
			foreach ($thread_replies as $reply) {
				$reply->user->user_reply_count = Reply::where('user_id', $reply->user->id)->count();
				$reply->user->user_karma = User::getKarma($reply->user->id);
			}
    		if (Auth::user() and $thread->votes->isNotEmpty()) {
    			if (Vote::where('user_id', '=', Auth::user()->id)->where('thread_id', '=', $thread->id)->where('vote_type', '=', 1)->exists()) {
    				$thread->user_has_voted = 'true';
    				$thread->user_vote_type = 1;
    			} 
                if (Vote::where('user_id', '=', Auth::user()->id)->where('thread_id', '=', $thread->id)->where('vote_type', '=', 0)->exists()) {
    				$thread->user_has_voted = 'true';
    				$thread->user_vote_type = 0;
                }
    		} else {
    			$thread->user_has_voted = 'false';  			
    		}
	    	
            if (Auth::user()) {
                if (DB::table('users_communities')->where('community_id', '=', $thread->communities->id)->where('user_id', '=', Auth::user()->id)->exists()) {
                        $thread->user_joined_community = 'true';
                } else {
                    $thread->user_joined_community = 'false';
                }
            }
            if (Auth::user()) {
            	if (UserCommunity::isUserAdmin(Auth::user()->id, $thread->communities->id)) {
            		$thread->user_is_admin = 'true';
            	}
            	if (UserCommunity::isUserLeader(Auth::user()->id, $thread->communities->id)) {
            		$thread->user_is_leader = 'true';
            	}
            }

            $community = Community::where('id', $community_id)->with('community_moderators')->with('community_rules')->withCount('threads')->first();
            $community->sub_count = UserCommunity::userCount($community_id);
			$community->index = Community::getCommunityPlacing($community_id);

			// META DESCRIPCION
			$tags = ThreadTags::where('thread_id', $thread_id)->get();
			$meta_description = 'Tags: '.implode(', ', $tags->pluck('tagname')->toArray()).'. ';
			if ($thread->type == "THREAD_POST") {
				$meta_description .= trim(preg_replace(['/<[^>]*>/','/\s+/'],' ', $thread->body));
			} elseif ($thread->type == "THREAD_YT") {
				$src =  preg_match( '@src="([^"]+)"@', $thread->body, $match);
				$meta_description .= 'YouTube · '.$match[1];
			} elseif ($thread->type == "THREAD_POLL") {
				foreach ($thread->poll_options as $poll_option) {
					$meta_description .= $poll_option->name.' '.$poll_option->percentage.'% / ';
				}
			} elseif ($thread->type == "THREAD_MEDIA") {
				$meta_description .= 'Galería de imágenes';
			}
			return view('layouts.desktop.templates.thread',
	    		[	'unread_notifications' => $unread_notifications,
	                'thread' => $thread,
	                'thread_replies' => $thread_replies,
	                'community' => $community,
	                'tags' => $tags,
	                'meta_description' => $meta_description
	    		]);
        
			}
		}

		function makeThread(Request $request) {
			if (Auth::user()) {
				return Thread::createThread($request);
			} else {
			    return response()->json(['response' => 'Ha ocurrido un problema (Error 500)']);
			}
		}

		function checkMultimedia(Request $request) {
			if (count($_FILES) <= 0 || count($_FILES) >= 10) {
				return response()->json(['error' => 'La cantidad de ficheros no es válida (Imágenes: 1 - 10 / Vídeos: 1)']);
			} else {
				$mimeImages = array("image/jpg", "image/jpeg", "image/png", "image/gif", "image/webp", "image/svg");
				$mimeVideos = array("video/mp4", "video/webm");
				$images = 0;
				$videos = 0;
				for ($i = 0; $i < count($_FILES); $i++) { 
					$file = $request->file('media'.$i);
					$filetype = $request->file('media'.$i)->getMimeType();
					if (in_array($filetype, $mimeImages)) {
						$images = $images+1;
						if ($request->file('media'.$i)->getSize() >= 2097152) { // 2 MB
							return response()->json(['error' => 'Uno o más archivos exceden el tamaño máximo para ficheros de imagen (2 Mb)']);
							break;
						}
					} elseif (in_array($filetype, $mimeVideos)) {
						$videos = $videos+1;
						if ($request->file('media'.$i)->getSize() >= 31457280) { // 30 MB
							return response()->json(['error' => 'Uno o más archivos exceden el tamaño máximo para ficheros de vídeo (30 Mb)']);
							break;
						}
					} else {
						return response()->json(['error' => 'Uno o más archivos exceden no tienen un formato válido']);
						break;
					}
				}
				if ($videos > 1) {
					return response()->json(['error' => 'No se permite la subida de más de un (1) archivo de vídeo por petición']);
				}
				if ($images >= 1 && $videos >= 1) {
					return response()->json(['error' => 'Solo se permite subir un tipo de archivo a la vez (Imagen o Vídeo)']);
				}
				$urlArray = [];
				for ($i = 0; $i < count($_FILES); $i++) {
					$upload = cloudinary()->upload($request->file('media'.$i)->getRealPath())->getSecurePath();
					array_push($urlArray, $upload);
				}
				return response()->json(['success' => $urlArray]);
			}
		}

		public function votePoll(Request $request) {
			if (Auth::user() && $request->ajax()) {
				if (PollOption::where('id', $request->option_id)->where('thread_id', $request->thread_id)->exists()) {
					PollVote::updateOrCreate([
						'user_id' => Auth::user()->id,
						'thread_id' => $request->thread_id
					],[
						'updated_at' => Carbon::now(),
					    'user_id' => Auth::user()->id,
					    'thread_id' => $request->thread_id,
						'option_id' => $request->option_id
					]);
					$poll_options = PollOption::where('thread_id', $request->thread_id)->withCount('votes')->get();
					$poll_total_votes = PollVote::getCountVotes($request->thread_id);
					foreach ($poll_options as $option) {
					    if ($poll_total_votes != 0) {
					        $option->percentage = round(($option->votes_count/$poll_total_votes)*100, 1);
					    } else {
					        $option->percentage = 0;
					    }
					}
					return response()->json(['success' => $poll_options]);		
				} else {
					return response()->json(['response' => '⚠️ Lo sentimos, hubo un problema con tu petición (Error 500) ⚠️']);		
				}
			} else {
				abort(404);
			}
		}

	function deleteThread(Request $request) {
	    $community_id = Thread::where('id', $request->thread_id)->value('community_id');
	    $thread = Thread::where('id', $request->thread_id)->with('author')->first();
	    if (Thread::where('id', $request->thread_id)->where('community_id', $community_id)->doesntExist()) {
	        return response()->json(['error' => '⚠️ Ha ocurrido un problema con tu petición (Error 500) ⚠️']);
	        abort(404);
	    }
	    if (Auth::user()) {
	        if (UserCommunity::isUserAdmin(Auth::user()->id, $community_id) || $thread->author->id == Auth::user()->id) {
	            Thread::where('id', $request->thread_id)->delete();
	        } else {
	            return response()->json(['error' => '⚠️ Ha ocurrido un problema con tu petición (Error 500) ⚠️']);
	            abort(404);
	        }
	    } else {
	        return response()->json(['error' => '⚠️ Ha ocurrido un problema con tu petición (Error 500) ⚠️']);
	        abort(404);
	    }
	}

	function closeThread(Request $request) {
    	$community_id = Thread::where('id', $request->thread_id)->value('community_id');
	    $thread = Thread::where('id', $request->thread_id)->with('author')->first();
	    if (Thread::where('id', $request->thread_id)->where('community_id', $community_id)->doesntExist()) {
	        return response()->json(['error' => '⚠️ Ha ocurrido un problema con tu petición (Error 500) ⚠️']);
	        abort(404);
	    }
	    if (Auth::user()) {
	        if (UserCommunity::isUserAdmin(Auth::user()->id, $community_id) || $thread->author->id == Auth::user()->id) {
	            Thread::where('id', $request->thread_id)->update(["closed" => 1]);
	        } else {
	            return response()->json(['error' => '⚠️ Ha ocurrido un problema con tu petición (Error 500) ⚠️']);
	            abort(404);
	        }
	    } else {
	        return response()->json(['error' => '⚠️ Ha ocurrido un problema con tu petición (Error 500) ⚠️']);
	        abort(404);
	    }
    }

}
 