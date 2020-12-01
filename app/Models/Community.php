<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
}