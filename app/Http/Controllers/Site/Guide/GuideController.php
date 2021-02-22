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
use App\Models\Guides;
use Auth;
use DB;
use Redirect;
use Paginator;

class GuideController extends Controller {

    function communitiesGuide($character = null) {
    $unread_notifications = app('App\Http\Controllers\Site\User\DataController')->unreadNotifications();
    $communities = Guides::getCommunities($character);
    //$communities = new \Illuminate\Pagination\Paginator($communities, 3, 1);
    return view('layouts.desktop.templates.guides.communities',
        [   'unread_notifications' => $unread_notifications,
            'communities' => $communities->paginate(2)
        ]);
    }

    function usersGuide($character = null) {
    $unread_notifications = app('App\Http\Controllers\Site\User\DataController')->unreadNotifications();
    $users = Guides::getUsers($character);
    return view('layouts.desktop.templates.guides.users',
        [   'unread_notifications' => $unread_notifications,
            'users' => $users->sortBy('name')
        ]);
    }

    function threadsGuide($character = null) {
    $unread_notifications = app('App\Http\Controllers\Site\User\DataController')->unreadNotifications();
    $threads = Guides::getThreads($character);
    return view('layouts.desktop.templates.guides.threads',
        [   'unread_notifications' => $unread_notifications,
            'threads' => $threads->sortByDesc('title')
        ]);
    }

    function topsByDate($date = null) {
    $unread_notifications = app('App\Http\Controllers\Site\User\DataController')->unreadNotifications();
    $communities = Guides::getTopCommunities($date);
    return view('layouts.desktop.templates.guides.tops',
        [   'unread_notifications' => $unread_notifications,
            'communities' => $communities
        ]);
    }
    
}
