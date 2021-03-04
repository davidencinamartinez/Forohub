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
        'description',
        'solved'
    ];

    public function threads() {
        return $this->belongsTo(Thread::class, 'thread_id');
    }

    public function author() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function createThreadReport($thread_id, $report_type, $description) {
    	ReportThread::create([
    	    'created_at' => Carbon::now(),
    	    'updated_at' => Carbon::now(),
    	    'user_id' => Auth::user()->id,
    	    'thread_id' => $thread_id,
    	    'report_type' => $report_type,
    	    'description' => $description,
            'solved' => 0
    	]);
    }
}
