<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model {

    use HasFactory;

    protected $fillable = [
        'created_at',
        'updated_at',
        'thread_id',
        'user_id',
        'text'
    ];

    protected $table = 'replies';

    public function thread() {
    	return $this->belongsTo(Thread::class, 'thread_id');
    }

    public function user() {
    	return $this->belongsTo(User::class, 'user_id');
    }

}