<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Auth;

class Notification extends Model {

    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'created_at',
        'updated_at',
        'user_id',
        'type',
        'notification',
    ];

    public function user() {
    	return $this->belongsTo('App\Models\User');
    }

    public static function createNotification($user_id, $notification, $type) {
    	Notification::create([
    	    'created_at' => Carbon::now(),
    	    'updated_at' => Carbon::now(),
    	    'user_id' => $user_id,
            'type' => $type,
    	    'notification' => $notification
    	]);
    }
}
