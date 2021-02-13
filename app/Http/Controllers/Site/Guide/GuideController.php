<?php

namespace App\Http\Controllers\Site\Guide;

use App\Http\Controllers\Controller;
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

class GuideController extends Controller {

    function communitiesGuide($character) {
    $unread_notifications = app('App\Http\Controllers\Site\User\DataController')->unreadNotifications();
    if ($character == "all") {
        $data = Community::withCount('threads')->take(50)->get();
    } else {
        if (is_numeric($character)) {
            $data = Community::where('tag', 'regexp', '^[0-9]+')->withCount('threads')->get();
        } else {
            $data = Community::where('tag', 'like', $character.'%')->withCount('threads')->get();
        }
    }
    foreach ($data as $community) {
        $community->sub_count = UserCommunity::userCount($community->id);
        $community->index = Community::getCommunityPlacing($community->id);
    }
    foreach ($data as $community) {
        if (Auth::check() && UserCommunity::where('community_id', $community->id)->where('user_id', Auth::user()->id)->whereIn('subscription_type', [2000,5000])->exists()) {
            $community->is_mod = true;
        }
    }
    return view('layouts.desktop.templates.guides.communities',
        [   'unread_notifications' => $unread_notifications,
            'data' => $data->sortBy('index')
        ]);
    }

    function usersGuide($character) {
    $unread_notifications = app('App\Http\Controllers\Site\User\DataController')->unreadNotifications();
    if ($character == "all") {
        $data = User::select('id','name','avatar','created_at')->withCount('messages')->withCount('threads')->take(50)->get();
    } else {
        if (is_numeric($character)) {
            $data = User::where('name', 'regexp', '^[0-9]+')->get();
        } else {
            $data = User::where('name', 'like', $character.'%')->get();
        }
    }
    foreach ($data as $user) {
        $user->karma = User::getKarma($user->id);
    }
    return view('layouts.desktop.templates.guides.users',
        [   'unread_notifications' => $unread_notifications,
            'data' => $data->sortBy('name')
        ]);
    }
}
