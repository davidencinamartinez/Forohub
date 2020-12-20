<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Auth;

class ReportThread extends Model {
    
    use HasFactory;

    protected $table = 'threads_reports';

    protected $fillable = [
        'created_at',
        'updated_at',
        'user_id',
        'thread_id',
        'report_type',
        'description'
    ];

    public static function createThreadReport($thread_id, $report_type, $description) {
    	ReportThread::create([
    	    'created_at' => Carbon::now(),
    	    'updated_at' => Carbon::now(),
    	    'user_id' => Auth::user()->id,
    	    'thread_id' => $thread_id,
    	    'report_type' => $report_type,
    	    'description' => $description
    	]);
    }
}
