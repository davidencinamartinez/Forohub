<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\UserCommunity;
use Illuminate\Support\Collection;

class Community extends Model {
    
    use HasFactory;

    public function users() {
    	return $this->hasMany(User::class);
    }

    public function threads() {
    	return $this->hasMany(Thread::class);
    }

    public function replies() {
    	return $this->hasManyThrough('App\Models\Reply', 'App\Models\Thread')->latest();
    }

    public function community_rules() {
        return $this->hasMany(CommunityRules::class);
    }

    public function community_moderators() {
        return $this->hasMany(UserCommunity::class)->with('user')->whereIn('subscription_type', [5000,2000]);
    }

    public function tags() {
        return $this->hasMany(CommunityTags::class, 'community_id');
    }

    public static function getCommunityScore($community_id) {
        $community_score = 0;
        $threads = Thread::where('community_id', $community_id)->get();
        foreach ($threads as $thread) {
            $upvotes = Vote::where('thread_id', $thread->id)->where('vote_type', 1)->count();
            $downvotes = Vote::where('thread_id', $thread->id)->where('vote_type', 0)->count();
            $community_score += 0.05+($upvotes*0.025)+($downvotes*(-0.025));
        }

        $community_score += UserCommunity::where('community_id', $community_id)->count()*0.035;

        return $community_score;
    }

    public static function getCommunityPlacing($community_id) {
        $communities = Community::get();
        foreach ($communities as $community) {
            $community->score = Community::getCommunityScore($community->id);
        }

        $sorted = $communities->sortByDesc('score');
        return array_search($community_id, array_column($sorted->toArray(), 'id'))+1;
    }
}