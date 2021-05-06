<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Auth;

class UserCommunity extends Model {

    use HasFactory;

    protected $fillable = [
        'created_at',
        'updated_at',
        'community_id',
        'user_id',
        'subscription_type'
    ];

    protected $table = 'users_communities';

    public function communities() {
        return $this->belongsTo(Community::class, 'community_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function userCount($community_id) {
        return UserCommunity::where('community_id', $community_id)->count();
    }

    public static function leaderJoinCommunity($community_id) {
        UserCommunity::create([
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'community_id' => $community_id,
            'user_id' => Auth::user()->id,
            'subscription_type' => 5000
        ]);
    }

    public static function JoinCommunity($community_id) {
        UserCommunity::create([
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'community_id' => $community_id,
            'user_id' => Auth::user()->id,
            'subscription_type' => 0
        ]);
    }

    public static function UnjoinCommunity($request) {
        $community_id = Community::where('tag', $request->community)->value('id');
        if (UserCommunity::where('community_id', '=', $community_id)->where('user_id', '=', Auth::user()->id)->where('subscription_type', 5000)->exists()) {
            return response()->json(['error' => '❗ Antes de abandonar esta comunidad, debes delegar tu liderazgo ❗']);
        } else {
            UserCommunity::where('community_id', $community_id)->where('user_id', Auth::user()->id)->delete();
            return response()->json(['success' => '😟 Has salido de la comunidad 😟']);
        }

    }

    public static function isUserMod($user_id, $community_id) {
        return UserCommunity::where('user_id', $user_id)
        ->where('community_id', $community_id)
        ->whereIn('subscription_type', [2000, 5000])
        ->exists();
    }

    public static function isUserAdmin($user_id, $community_id) {
        return UserCommunity::where('user_id', $user_id)
        ->where('community_id', $community_id)
        ->where('subscription_type', 2000)
        ->exists();
    }

    public static function isUserLeader($user_id, $community_id) {
        return UserCommunity::where('user_id', $user_id)
        ->where('community_id', $community_id)
        ->where('subscription_type', 5000)
        ->exists();
    }

    public static function isUserSubscribed($user_id, $community_id) {
        return UserCommunity::where('community_id', $community_id)
        ->where('user_id', Auth::user()->id)
        ->exists();
    }

    public static function rankUserCommunity($user_id, $community, $subscription_type, $rank) {
        // Rank Update
        UserCommunity::where('user_id', $user_id)
        ->where('community_id', $community->id)
        ->update(['subscription_type' => $subscription_type]);
        if ($subscription_type === 5000) {
            UserCommunity::where('community_id', $community->id)
            ->where('user_id', Auth::user()->id)
            ->update(['subscription_type' => 0]);
            // Notification JSON
            $data["community_tag"] = $community->tag;
            $data["community_title"] = $community->title;
            $data["community_logo"] = $community->logo;
            $data["user_rank"] = "Afiliado";
            Notification::createNotification(Auth::user()->id, json_encode($data), "community_rank");
        }
        $data["user_rank"] = $rank;
        $data["community_tag"] = $community->tag;
        $data["community_title"] = $community->title;
        $data["community_logo"] = $community->logo;
        Notification::createNotification($user_id, json_encode($data), "community_rank");
    }
    
}
