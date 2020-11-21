<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    public function thread() {
    	return $this->belongsTo(Thread::class, 'thread_id');
    }

    public function user() {
    	return $this->belongsTo(User::class, 'user_id');
    }

}

/*
countries -> replies
post -> communities 
user -> threads

*/