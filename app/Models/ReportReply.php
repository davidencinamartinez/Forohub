<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Auth;

class ReportReply extends Model {

    use HasFactory;

    protected $table = 'replies_reports';

    public function author() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function replies() {
        return $this->belongsTo(Reply::class, 'reply_id');
    }

    protected $fillable = [
        'created_at',
        'updated_at',
        'user_id',
        'reply_id',
        'report_type',
        'description',
        'solved'
    ];

    public static function createReplyReport($reply_id, $report_type, $description) {
    	ReportReply::create([
    	    'created_at' => Carbon::now(),
    	    'updated_at' => Carbon::now(),
    	    'user_id' => Auth::user()->id,
    	    'reply_id' => $reply_id,
    	    'report_type' => $report_type,
    	    'description' => $description,
            'solved' => 0
    	]);
    }
}