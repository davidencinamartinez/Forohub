<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PollOption extends Model {

    use HasFactory;

    protected $fillable = [
        'created_at',
        'updated_at',
        'thread_id',
        'name'
    ];

    protected $table = 'poll_options';

    public static function createPollOption($thread_id, $option_name) {
    	PollOption::create([
    	    'created_at' => Carbon::now(),
    	    'updated_at' => Carbon::now(),
    	    'thread_id' => $thread_id,
    	    'name' => $option_name
    	]);
    }

    public function votes() {
    	return $this->hasMany(PollVote::class, 'option_id');
    }

}
