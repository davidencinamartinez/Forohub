<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityRules extends Model {

    use HasFactory;

    protected $table = 'communities_rules';

    protected $fillable = [
        'created_at',
        'updated_at',
        'community_id',
        'rule',
        'rule_description'
    ];

    public function communities() {
    	return $this->belongsTo(Community::class, 'community_id');
    }
}
