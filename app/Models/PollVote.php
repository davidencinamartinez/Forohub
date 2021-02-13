<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Auth;

class PollVote extends Model {

    use HasFactory;

    protected $fillable = [
        'created_at',
        'updated_at',
        'user_id',
        'thread_id',
        'option_id'
    ];

    protected $table = 'poll_votes';

    public static function getCountVotes($thread_id) {
    	$options = PollOption::where('thread_id', $thread_id)->get('id');
    	$total = 0;
    	foreach ($options as $option) {
    		$total += PollVote::where('option_id', $option->id)->count();
    	}
    	return $total;
    }

    public static function votePollOption($thread_id, $option_id) {
    	PollVote::create([
    		'created_at' => Carbon::now(),
    		'updated_at' => Carbon::now(),
    		'user_id' => Auth::user()->id,
            'thread_id' => $thread_id,
    		'option_id' => $option_id
    	]);
    }

}
