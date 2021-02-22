<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Community;
use App\Models\CommunityTags;
use App\Models\Thread;
use App\Models\PollVote;
use App\Models\PollOption;
use App\Models\UserCommunity;
use App\Models\Vote;
use App\Models\User;
use App\Models;
use Auth;
use DB;
use Redirect;

class Guides extends Model {

    use HasFactory;

    public static function getCommunities($character) {
    	if (!empty($character)) {
    	    if (is_numeric($character)) {
    	        $communities = Community::where('tag', 'regexp', '^[0-9]+')->withCount('threads')->get();
    	    } else {
    	        $communities = Community::where('tag', 'like', $character.'%')->withCount('threads')->get();
    	    }
    	} else {
    	    $communities = Community::withCount('threads')->take(50)->get();
    	}
    	foreach ($communities as $community) {
    	    $community->sub_count = UserCommunity::userCount($community->id);
    	    $community->index = Community::getCommunityPlacing($community->id);
    	}
    	foreach ($communities as $community) {
    	    if (Auth::check() && UserCommunity::where('community_id', $community->id)->where('user_id', Auth::user()->id)->whereIn('subscription_type', [2000,5000])->exists()) {
    	        $community->is_mod = true;
    	    }
    	}
    	return $communities;
    }

    public static function getUsers($character) {
    	if (!empty($character)) {
    	    if (is_numeric($character)) {
    	        $users = User::where('name', 'regexp', '^[0-9]+')->withCount('messages')->withCount('threads')->take(50)->get();
    	    } else {
    	        $users = User::where('name', 'like', $character.'%')->withCount('messages')->withCount('threads')->take(50)->get();
    	    }
    	} else {
    	    $users = User::select('id','name','avatar','created_at')->withCount('messages')->withCount('threads')->take(50)->get();
    	}
    	foreach ($users as $user) {
    	    $user->karma = User::getKarma($user->id);
    	}
    	return $users;
    }

    public static function getThreads($character) {
    	if (!empty($character)) {
    	    if (is_numeric($character)) {
    	        $threads = Thread::where('title', 'regexp', '^[0-9]+')->with('author')->withCount('replies')->withCount('upvotes')->withCount('downvotes')->take(50)->get();
    	    } else {
    	        $threads = Thread::where('title', 'like', $character.'%')->with('author')->withCount('replies')->withCount('upvotes')->withCount('downvotes')->take(50)->get();
    	    }
    	} else {
    	    $threads = Thread::select('id','title','user_id','created_at','spoiler','nsfw','important','community_id','type')->with('author')->withCount('replies')->withCount('upvotes')->withCount('downvotes')->take(50)->get();
    	}
    	foreach ($threads as $thread) {
    	   $community_id = $thread->community_id;
    	   $community_tag = Community::where('id', $community_id)->value('tag');
    	   $thread->community_tag = $community_tag;
    	}
    	return $threads;
    }

    public static function getTopCommunities($date) {
    	if ($date == "semana") {
    		$communities = Community::withCount('threads')->get();
			foreach ($communities as $community) {
    	    	$community->index = Community::getCommunityPlacing($community->id);
    		}
    		$communities->sortBy('index')->take(2);
    		foreach ($communities as $community) {
    	    	$community->sub_count = UserCommunity::userCount($community->id);
    	    	if (Auth::check() && UserCommunity::where('community_id', $community->id)->where('user_id', Auth::user()->id)->whereIn('subscription_type', [2000,5000])->exists()) {
    	        	$community->is_mod = true;
    	    	}
    		}
		return $communities;
    	}
    }
}
