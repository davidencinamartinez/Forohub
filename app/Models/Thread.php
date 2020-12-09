<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

    public function communities() {
    	return $this->belongsTo(Community::class, 'community_id');
    }

    public function author() {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function replies() {
    	return $this->hasMany(Reply::class);
    }

    public function first_reply() {
        return $this->hasMany(Reply::class)->oldest();
    }

    public function votes() {
        return $this->hasMany(Vote::class);
    }

    public function upvotes() {
        return $this->hasMany(Vote::class, 'thread_id')->where('vote_type', 1);
    }

    public function downvotes() {
        return $this->hasMany(Vote::class, 'thread_id')->where('vote_type', 0);
    }
}
