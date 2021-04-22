<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Thread;
use Auth;

class Vote extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
     protected $fillable = [
        'user_id',
        'vote_type',
        'thread_id',
    ];

    public function threads() {
    	return $this->belongsTo(Thread::class, 'thread_id');
    }

    public function users() {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public static function getUserUpvotes($thread_id) {
        $thread_author_upvote_count = 0;
        $thread_author_id = Thread::where('id', $thread_id)->value('user_id');
        $author_threads = Thread::where('user_id', $thread_author_id)->get();
        foreach ($author_threads as $thread) {
            $thread_author_upvote_count = $thread_author_upvote_count+Vote::where('thread_id', $thread->id)->count();   
        }
        return $thread_author_upvote_count;
    }

    public static function hasUserVotedThread($thread_id, $vote_type) {
        return Vote::where('user_id', Auth::user()->id)
                ->where('thread_id', $thread_id)
                ->where('vote_type', $vote_type)
                ->exists();
    }

    public static function deleteUserVotedThread($thread_id, $vote_type) {
        Vote::where('user_id', Auth::user()->id)
        ->where('thread_id', $thread_id)
        ->where('vote_type', $vote_type)
        ->delete();
    }

    public static function getThreadVotes($thread_id) {
        $upvotes = Vote::where('thread_id', $thread_id)
        ->where('vote_type', 1)->count();
        $downvotes = Vote::where('thread_id', $thread_id)
        ->where('vote_type', 0)->count();
        return $upvotes-$downvotes;
    }
}
