<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
