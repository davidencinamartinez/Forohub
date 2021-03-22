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

    public function reports() {
        return $this->hasMany(ReportReply::class, 'reply_id');
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
        $values = array_unique($matches[0]);
        foreach ($values as $key => $value) {
            $username = str_replace("@", "", $value);
            if (User::where('name', $username)->exists()) {
                $user_id = User::where('name', $username)->value('id');
                Notification::createNotification($user_id, $thread_id, "mention");
            }    
        }
    }

    public static function removeReply($request) {
        if (Auth::user()) {
            $community_id = Reply::where('id', $request->reply_id)
                            ->with('thread.communities')
                            ->get()->pluck('thread.communities')
                            ->first()->value('id');
            if (UserCommunity::where('user_id', Auth::user()->id)->where('community_id', $community_id)->whereIn('subscription_type', [2000,5000])->doesntExist()) {
                abort(404);
            } else {
                Reply::where('id', $request->reply_id)->update(['text' => '<i>Mensaje eliminado</i>']);
            }
        } else {
            abort(404);
        }
    }

}