<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Community;
use App\Models\Guides;
use App\Models\Thread;
use App\Models\Reward;
use App\Models\Vote;
use App\Models\Reply;
use App\Models\UserReward;
use App\Models\UserCommunity;
use App\Models\UserCommunityBan;
use App\Models\Notification;
use App\Models\PollOption;
use App\Models\ReportReply;
use App\Models\ReportThread;
use App\Models\PollVote;
use Carbon\Carbon;
use Auth;
use Validator;
use DB;
use App\Models\VerifyUser;

class IndexController extends Controller {

    /* INDEX */

    public function index() {
        // Unread Notifications
        $unread_notifications = app('App\Http\Controllers\Site\User\DataController')->unreadNotifications();
        // Threads
    	$threads = Thread::orderBy('created_at', 'desc')
        ->with('communities')
        ->with('author')
        ->withCount('replies')
        ->withCount('upvotes')
        ->withCount('downvotes')
        ->paginate(4, ['*'], 'pagina');
        // Foreach Thread Loop
        foreach ($threads as $thread) {
            // Is User Loged
            if (Auth::check()) {
                // Has User Voted Thread
                if ($thread->votes->isNotEmpty()) {
                    if (Vote::where('user_id', Auth::user()->id)
                    ->where('thread_id', $thread->id)
                    ->where('vote_type', 1)
                    ->exists()) {
                        $thread->user_has_voted = 'true';
                        $thread->user_vote_type = 1;
                    } elseif (Vote::where('user_id', Auth::user()->id)
                    ->where('thread_id', $thread->id)
                    ->where('vote_type', 0)
                    ->exists()) {
                        $thread->user_has_voted = 'true';
                        $thread->user_vote_type = 0;
                    }
                } else {
                    $thread->user_has_voted = 'false';              
                }
                // Is User Subscribed To Community
                if (DB::table('users_communities')->where('community_id', $thread->communities->id)
                    ->where('user_id', Auth::user()->id)
                    ->exists()) {
                        $thread->user_joined_community = 'true';
                } else {
                    $thread->user_joined_community = 'false';
                }
            }
            // Is Thread Poll
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
        // Top Communities
        $top_communities = Community::get();
        foreach ($top_communities as $community) {
            $community->score = Community::getCommunityScore($community->id);
        }
        $sorted_top_communities = $top_communities->sortByDesc('score')->take(6);
        // Forohub Data
        $fh_data = array(
            'count_communities' => Community::count(),
            'count_users' => User::count(),
            'count_threads' => Thread::count(),
            'count_replies' => Reply::count(),
        );
        // Latest Replies           
        $latest_replies = Reply::join('threads', 'threads.id', '=', 'replies.thread_id')
        ->join('communities', 'communities.id', '=', 'threads.community_id')
        ->join('users', 'users.id', '=', 'replies.user_id')
        ->select('replies.created_at', 'users.name', 'threads.title', 'communities.tag', 'threads.id', 'replies.text')
        ->orderBy('replies.created_at', 'desc')
        ->take(5)
        ->get();
        // If Threads Are Null
        if ($threads->isEmpty()) {
            return redirect()->route('index');
        }
        // Meta Description
        $meta_description = "Forohub es una red de comunidades basada en los intereses de sus usuarios. Podrás encontrar la respuesta a cualquier tipo de consulta que tengas. Y si no la encuentras, pregunta y te ayudaremos! Aquí estamos para eso";
        // Return Data
        return view('layouts.desktop.templates.index',
            [   'unread_notifications' => $unread_notifications,
                'threads' => $threads,
                'fh_data' => $fh_data,
                'top_communities' => $sorted_top_communities,
                'latest_replies' => $latest_replies,
                'meta_description' => $meta_description
            ]);
    }   

    /* RELEVANT INDEX */

    public function relevantIndex() {
        // Unread Notifications
        $unread_notifications = app('App\Http\Controllers\Site\User\DataController')->unreadNotifications();
        // Relevant Threads
        $threads = Thread::with('communities')
        ->with('author')
        ->with('first_reply')
        ->withCount('replies')
        ->withCount('upvotes')
        ->withCount('downvotes')
        ->orderBy('upvotes_count', 'desc')
        ->whereBetween('created_at', [Carbon::now()->subDays(7), Carbon::now()])
        ->paginate(4, ['*'], 'pagina');
        // Foreach Thread Loop
        foreach ($threads as $thread) {
            // Is User Loged
            if (Auth::check()) {
                // Has User Voted Thread
                if ($thread->votes->isNotEmpty()) {
                    if (Vote::where('user_id', Auth::user()->id)
                    ->where('thread_id', $thread->id)
                    ->where('vote_type', 1)
                    ->exists()) {
                        $thread->user_has_voted = 'true';
                        $thread->user_vote_type = 1;
                    } elseif (Vote::where('user_id', Auth::user()->id)
                    ->where('thread_id', $thread->id)
                    ->where('vote_type', 0)
                    ->exists()) {
                        $thread->user_has_voted = 'true';
                        $thread->user_vote_type = 0;
                    }
                } else {
                    $thread->user_has_voted = 'false';              
                }
                // Is User Subscribed To Community
                if (DB::table('users_communities')
                    ->where('community_id', $thread->communities->id)
                    ->where('user_id', Auth::user()->id)
                    ->exists()) {
                        $thread->user_joined_community = 'true';
                } else {
                    $thread->user_joined_community = 'false';
                }
            }
            // Is Thread Poll
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
        // Top Communities
        $top_communities = Community::get();
        foreach ($top_communities as $community) {
            $community->score = Community::getCommunityScore($community->id);
        }
        $sorted_top_communities = $top_communities->sortByDesc('score')->take(6);
        // Forohub Data
        $fh_data = array(
            'count_communities' => Community::count(),
            'count_users' => User::count(),
            'count_threads' => Thread::count(),
            'count_replies' => Reply::count(),
        );
        // Latest Replies           
        $latest_replies = Reply::join('threads', 'threads.id', '=', 'replies.thread_id')
        ->join('communities', 'communities.id', '=', 'threads.community_id')
        ->join('users', 'users.id', '=', 'replies.user_id')
        ->select('replies.created_at', 'users.name', 'threads.title', 'communities.tag', 'threads.id', 'replies.text')
        ->orderBy('replies.created_at', 'desc')
        ->take(5)
        ->get();
        // If Threads Are Null
        if ($threads->isEmpty()) {
            return redirect()->route('index');
        }
        // Meta Description
        $meta_description = "Aquí aparecerán los temas más populares del foro. La popularidad de estos es basada en el número de mensajes y el número de votos positivos recibidos. Si uno de tus temas se populariza, es probable que recibas alguna recompensa, ya sea que aumente tu karma dentro del foro, o incluso conseguir algún logro";
        // Return Data
        return view('layouts.desktop.templates.index',
            [   'unread_notifications' => $unread_notifications,
                'threads' => $threads,
                'fh_data' => $fh_data,
                'top_communities' => $sorted_top_communities,
                'latest_replies' => $latest_replies,
                'meta_description' => $meta_description
            ]);
    }

    /* VOTE THREAD */

    public function voteThread(Request $request) {
        // If Not Ajax
        if (!$request->ajax()) {
            abort(404);
        }
        // If User Not Logged In
        if (!Auth::check()) {
            abort(404);
        }
        // Validation
        $validator = Validator::make($request->all(), ['vote_type' => 'min:0|max:1']);
        if (!$validator->passes()) {
            // If Validation Fails
            return response()->json(['response' => '⚠️ Lo sentimos, hubo un problema con tu petición (Error 500) ⚠️']);
        } else {
            // If Vote Exists -> Delete
            if (Vote::hasUserVotedThread($request->thread_id, $request->vote_type)) {
                Vote::deleteUserVotedThread($request->thread_id, $request->vote_type);
            } else {
                // Create Vote
                Vote::updateOrCreate(
                    ['user_id' => Auth::user()->id, 'thread_id' => $request->thread_id],
                    ['vote_type' => $request->vote_type]);
                // Reward Thread Author
                $thread_author_id = Thread::where('id', $request->thread_id)->value('user_id');
                if (User::getUserUpvotes($thread_author_id) == 1) {
                    if (!UserReward::userHasReward($thread_author_id, 12)) {
                        UserReward::createUserReward($thread_author_id, 12);
                    }
                }
            }
            return response()->json([
                'response' => '💾 Se han guardado los cambios 💾',
                'votes' => Vote::getThreadVotes($request->thread_id)
            ]);
        }
    }

    function test() {

        return Guides::getTopUsers();



    }

}
