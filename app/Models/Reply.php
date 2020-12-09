<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\User;
use Auth;

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

    public function replyCount($user_id) {
        return Reply::where('user_id', $user_id)->count();
    }

    public static function createReply($thread_id, $text) {
    	Reply::create([
    		'created_at' => Carbon::now(),
    		'updated_at' => Carbon::now(),
    		'thread_id' => $thread_id,
    		'user_id' => Auth::user()->id,
    		'text' => $text
    	]);
    }

    public static function mentionUser($reply, $thread_id) {
        $match = preg_match_all("/@[a-zA-Z0-9]{0,20}/", $reply, $matches);

        foreach ($matches[0] as $key => $value) {
            $username = str_replace("@", "", $value);
            if (User::where('name', $username)->exists()) {
                $user_id = User::where('name', $username)->value('id');
                Notification::createNotification($user_id, "Te han mencionado en un tema (".$thread_id.")", "mention");
            }    
        }
    }

}