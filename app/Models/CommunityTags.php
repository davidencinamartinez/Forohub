<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CommunityTags extends Model
{
    use HasFactory;

    protected $table = 'communities_tags';

    protected $fillable = [
        'created_at',
        'updated_at',
        'community_id',
        'tagname'
    ];

    public function community() {
    	return $this->belongsTo(Community::class, 'id');
    }

    public static function newCommunityTag($community_id, $tag) {
        CommunityTags::create([
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'community_id' => $community_id,
            'tagname' => $tag
        ]);
    }
}
