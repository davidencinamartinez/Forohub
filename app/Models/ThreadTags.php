<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ThreadTags extends Model {

    use HasFactory;

    protected $fillable = [
        'created_at',
        'updated_at',
        'thread_id',
        'tagname'
    ];

    protected $table = 'threads_tags';

    public static function createThreadTags($thread_id, $tags) {
    	foreach ($tags as $tag) {
    		ThreadTags::create([
    			'created_at' => Carbon::now(),
    			'updated_at' => Carbon::now(),
    			'thread_id' => $thread_id,
    			'tagname' => $tag
    		]);
    	}
    }


}
