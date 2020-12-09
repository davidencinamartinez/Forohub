<?php

namespace App\Http\Controllers\Site\Thread;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reply;
use App\Models\Notification;
use App\Models\UserReward;
use App\Models\Thread;
use App\Models\Community;
use App\Models\User;
use App\Models\Vote;
use DB;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Validator;

class ThreadController extends Controller {

	public function getThreadData($community_tag, $thread_id) {

			$unread_notifications = app('App\Http\Controllers\Site\User\DataController')->unreadNotifications();

			$community_id = Community::where('tag', $community_tag)->value('id');

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
			->get();

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
		        
				return view('layouts.desktop.templates.thread',
		    		[	'unread_notifications' => $unread_notifications,
		                'thread' => $thread,
		                'thread_replies' => $thread_replies
		                
		    		]);
        
			}
}

    
}
 