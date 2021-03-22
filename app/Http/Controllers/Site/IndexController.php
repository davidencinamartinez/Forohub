<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Community;
use App\Models\Thread;
use App\Models\Reward;
use App\Models\Vote;
use App\Models\Reply;
use App\Models\UserReward;
use App\Models\UserCommunity;
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

        $unread_notifications = app('App\Http\Controllers\Site\User\DataController')->unreadNotifications();

    	$threads = Thread::orderBy('created_at', 'desc')
        ->with('communities')
        ->with('author')
        ->with('first_reply')
        ->withCount('replies')
        ->withCount('upvotes')
        ->withCount('downvotes')
        ->paginate(4, ['*'], 'pagina');

        $top_communities = Community::get();
        foreach ($top_communities as $community) {
            $community->score = Community::getCommunityScore($community->id);
        }
        $sorted_top_communities = $top_communities->sortByDesc('score')->take(6);

        $fh_data = array(
            'count_communities' => Community::count(),
            'count_users' => User::count(),
            'count_threads' => Thread::count(),
            'count_replies' => Reply::count(),
        );
                
        $latest_replies = Reply::join('threads', 'threads.id', '=', 'replies.thread_id')->join('communities', 'communities.id', '=', 'threads.community_id')->join('users', 'users.id', '=', 'replies.user_id')->select('replies.created_at', 'users.name', 'threads.title', 'communities.tag', 'threads.id', 'replies.text')->orderBy('replies.created_at', 'desc')->take(5)->get();
        
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

        if ($threads->isEmpty()) {
            return redirect()->route('index');
        }

    	return view('layouts.desktop.templates.index',
    		[	'unread_notifications' => $unread_notifications,
                'threads' => $threads,
                'fh_data' => $fh_data,
                'top_communities' => $sorted_top_communities,
                'latest_replies' => $latest_replies
    		]);
    }

    /* FEATURED INDEX */

    public function featuredIndex() {

        $unread_notifications = app('App\Http\Controllers\Site\User\DataController')->unreadNotifications();

        $threads = Thread::with('communities')
        ->with('author')
        ->with('first_reply')
        ->withCount('replies')
        ->withCount('upvotes')
        ->withCount('downvotes')
        ->orderBy('upvotes_count', 'desc')
        ->whereBetween('created_at', [Carbon::now()->subDays(7), Carbon::now()])
        ->paginate(4, ['*'], 'pagina');

        $top_communities = Community::get();
        foreach ($top_communities as $community) {
            $community->score = Community::getCommunityScore($community->id);
        }
        $sorted_top_communities = $top_communities->sortByDesc('score')->take(6);

        $fh_data = array(
            'count_communities' => Community::count(),
            'count_users' => User::count(),
            'count_threads' => Thread::count(),
            'count_replies' => Reply::count(),
        );
                
        $latest_replies = Reply::join('threads', 'threads.id', '=', 'replies.thread_id')->join('communities', 'communities.id', '=', 'threads.community_id')->join('users', 'users.id', '=', 'replies.user_id')->select('replies.created_at', 'users.name', 'threads.title', 'communities.tag', 'threads.id', 'replies.text')->orderBy('replies.created_at', 'desc')->take(5)->get();
        
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

        if ($threads->isEmpty()) {
            return redirect()->route('index');
        }

        return view('layouts.desktop.templates.index',
            [   'unread_notifications' => $unread_notifications,
                'threads' => $threads,
                'fh_data' => $fh_data,
                'top_communities' => $sorted_top_communities,
                'latest_replies' => $latest_replies
            ]);
    }

    /* VOTE THREAD */

    public function voteThread(Request $request) {
        if ($request->ajax()) {
            if (Auth::user()) {
                $validator = Validator::make($request->all(), ['vote_type' => 'min:0|max:1']);
                if (!$validator->passes()) {
                    return response()->json(['response' => '⚠️ Lo sentimos, hubo un problema con tu petición (Error 500) ⚠️']);
                } else {
                    if (Vote::where('user_id', '=', Auth::user()->id)
                        ->where('thread_id', '=', $request->thread_id)
                        ->where('vote_type', '=', $request->vote_type)
                        ->exists()) {

                        Vote::where('user_id', '=', Auth::user()->id)
                        ->where('thread_id', '=', $request->thread_id)
                        ->where('vote_type', '=', $request->vote_type)
                        ->delete();
                        return response()->json([
                            'response' => '💾 Se han guardado los cambios 💾',
                            'votes' => Vote::where('thread_id', $request->thread_id)->where('vote_type', 1)->count() - Vote::where('thread_id', $request->thread_id)->where('vote_type', 0)->count()
                        ]);
                    } else {
                        Vote::updateOrCreate(
                            ['user_id' => Auth::user()->id, 'thread_id' => $request->thread_id],
                            ['vote_type' => $request->vote_type]);

                        $thread_author_id = Thread::where('id', $request->thread_id)->value('user_id');
                        if (Vote::getUserUpvotes($request->thread_id) == 1) {
                            if (UserReward::userHasReward($thread_author_id, 10) == false) {
                                UserReward::createUserReward($thread_author_id, 10);
                                Notification::createNotification($thread_author_id, "Logro desbloqueado: Me gusta", "reward");
                            }
                        }
                        return response()->json([
                            'response' => '💾 Se han guardado los cambios 💾',
                            'votes' => Vote::where('thread_id', $request->thread_id)->where('vote_type', 1)->count() - Vote::where('thread_id', $request->thread_id)->where('vote_type', 0)->count()
                        ]);
                    }
                }
            } else {
               return response()->json(['response' => '😁 Debes estar logeado para poder votar 😁']);
            }
        } 
            return response()->json(['response' => '⚠️ Lo sentimos, hubo un problema con tu petición (Error 500) ⚠️']);
        
    }

    /* USER THREADS */

        function userThreads($user_id) {

            $threads = Thread::orderBy('created_at', 'desc')
            ->where('user_id', $user_id)
            ->with('communities')
            ->with('author')
            ->withCount('replies')
            ->withCount('upvotes')
            ->withCount('downvotes')
            ->paginate(4, ['*'], 'pagina');

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
        return response()->json([
            'threads' => $threads
        ]);
    }
    
    /* TEST */	
    
    public function fileUpload(Request $request){
        $response = cloudinary()->upload($request->file('file')->getRealPath())->getSecurePath();

                dd($response);

                return back()
                    ->with('success', 'File uploaded successfully');


        
      }
         function createForm() {
            return view('layouts.test');
         }

         function test() {
            
            $lala = '<div class="slideshow-content" data-source="https://res.cloudinary.com/dt4uoou5x/image/upload/v1615986146/kfduhzyfhct4a3jhvrr0.gif,https://res.cloudinary.com/dt4uoou5x/image/upload/v1615986147/qrytboxjdc5paeoitrxs.jpg,https://res.cloudinary.com/dt4uoou5x/image/upload/v1615986148/n56di08fxxtsimjsdlwo.jpg,https://res.cloudinary.com/dt4uoou5x/image/upload/v1615986150/zvchhcrynix9kip7k5rs.jpg"><div class="slideshow-media blurry"><div class="blurry-container"><div class="nsfw-banner"><label>🔞</label><label>Contenido NSFW</label><label>Si deseas visualizarlo, haz click aquí</label></div></div><img src="https://res.cloudinary.com/dt4uoou5x/image/upload/v1615986146/kfduhzyfhct4a3jhvrr0.gif" data-id="0"></div><a class="slide-previous">❮</a><a class="slide-next">❯</a><label class="slideshow-page">1/1</label></div><marquee behavior="scroll" direction="left" scrollamount="10" onmouseover="stop()" onmouseleave="start()">sdfsdfdsf</marquee>';

            preg_match( '@src="([^"]+)"@', $lala, $match);

            return $match;
            
            
        
            
         }
}
