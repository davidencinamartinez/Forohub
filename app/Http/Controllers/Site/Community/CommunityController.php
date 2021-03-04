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
use Auth;
use DB;
use Redirect;

class CommunityController extends Controller {
    
    function getCommunity($community_tag) {

    	$communityId = Community::where('tag', $community_tag)->value('id');

    	$unread_notifications = app('App\Http\Controllers\Site\User\DataController')->unreadNotifications();

		$threads = Thread::orderBy('created_at', 'desc')
	    ->where('community_id', $communityId)
	    ->with('communities')
	    ->with('author')
	    ->with('first_reply')
	    ->withCount('replies')
	    ->withCount('upvotes')
	    ->withCount('downvotes')
	    ->paginate(4, ['*'], 'pagina');

	    $community = Community::where('id', $communityId)->with('community_moderators')->with('community_rules')->withCount('threads')->first();
        $community->sub_count = UserCommunity::userCount($communityId);
		$community->index = Community::getCommunityPlacing($communityId);

		if (Auth::user()) {
			foreach ($community->community_moderators as $moderator) {
				if ($moderator->user_id == Auth::user()->id) {
					$community->is_mod = 'true';
				}
			}
		}

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
}
