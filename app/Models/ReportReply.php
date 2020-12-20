<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Auth;

class ReportReply extends Model {

    use HasFactory;

    protected $table = 'replies_reports';

    protected $fillable = [
        'created_at',
        'updated_at',
        'user_id',
        'reply_id',
        'report_type',
        'description'
    ];

    public static function createReplyReport($reply_id, $report_type, $description) {
    	ReportReply::create([
    	    'created_at' => Carbon::now(),
    	    'updated_at' => Carbon::now(),
    	    'user_id' => Auth::user()->id,
    	    'reply_id' => $reply_id,
    	    'report_type' => $report_type,
    	    'description' => $description
    	]);
    }
}