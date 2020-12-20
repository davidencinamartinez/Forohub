<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityTags extends Model
{
    use HasFactory;

    protected $table = 'communities_tags';

    protected $fillable = [
        'created_at',
        'updated_at',
        'user_id',
        'type',
        'notification',
    ];

    public function community() {
    	return $this->belongsTo(Community::class, 'id');
    }
}
