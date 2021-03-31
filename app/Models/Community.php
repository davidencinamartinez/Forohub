<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\UserCommunity;
use App\Models\UserReward;
use Auth;
use App\Models\CommunityTags;
use Illuminate\Support\Collection;
use Validator;

class Community extends Model {
    
    use HasFactory;

    protected $fillable = [
        'created_at',
        'updated_at',
        'tag',
        'title',
        'description',
        'logo',
        'banner',
        'background'
    ];

    protected $table = 'communities';

    public function users() {
    	return $this->hasMany(UserCommunity::class);
    }

    public function thread_reports() {
        return $this->hasManyThrough(ReportThread::class, Thread::class);
    }

    public function reply_reports() {
        return $this->hasManyThrough(Reply::class, Thread::class)->join('replies_reports', 'replies_reports.reply_id', '=', 'replies.id')->where('threads.community_id', $this->id)->where('replies.thread_id', 'threads.id');
    }

    public function threads() {
    	return $this->hasMany(Thread::class);
    }

    public function replies() {
    	return $this->hasManyThrough('App\Models\Reply', 'App\Models\Thread')->latest();
    }

    public function community_rules() {
        return $this->hasMany(CommunityRules::class);
    }

    public function community_moderators() {
        return $this->hasMany(UserCommunity::class)->with('user')->whereIn('subscription_type', [5000,2000]);
    }

    public function tags() {
        return $this->hasMany(CommunityTags::class, 'community_id');
    }

    public static function getCommunityScore($community_id) {
        $community_score = 0;
        $threads = Thread::where('community_id', $community_id)->get();
        foreach ($threads as $thread) {
            $upvotes = Vote::where('thread_id', $thread->id)->where('vote_type', 1)->count();
            $downvotes = Vote::where('thread_id', $thread->id)->where('vote_type', 0)->count();
            $community_score += 0.05+($upvotes*0.025)+($downvotes*(-0.025));
        }

        $community_score += UserCommunity::where('community_id', $community_id)->count()*0.035;

        return $community_score;
    }

    public static function getTopCommunityScore($community_id, $time) {
        $community_score = 0;
        $threads = Thread::where('community_id', $community_id)->get();
        foreach ($threads as $thread) {
            $upvotes = Vote::where('thread_id', $thread->id)->where('vote_type', 1)->count();
            $downvotes = Vote::where('thread_id', $thread->id)->where('vote_type', 0)->count();
            $community_score += 0.05+($upvotes*0.025)+($downvotes*(-0.025));
        }

        $community_score += UserCommunity::where('community_id', $community_id)->count()*0.035;

        return $community_score;
    }

    public static function getCommunityPlacing($community_id) {
        $communities = Community::get();
        foreach ($communities as $community) {
            $community->score = Community::getCommunityScore($community->id);
        }

        $sorted = $communities->sortByDesc('score');
        return array_search($community_id, array_column($sorted->toArray(), 'id'))+1;
    }

    public static function createCommunity($request) {
        $messages = [
            // TAG
            'tag.required' => 'Campo vacío (Etiqueta)',
            'tag.unique' => 'Esta etiqueta no está disponible (Ocupada)',
            'tag.min' => 'La etiqueta debe contener mínimo 3 carácteres',
            'tag.max' => 'La etiqueta debe contener máximo 30 carácteres',
            'tag.regex' => 'La etiqueta sólo puede contener letras y números (No pueden haber espacios)',
            // TITLE
            'title.required' => 'Campo vacío (Nombre)',
            'title.min' => 'El nombre de la comunidad debe contener mínimo 3 carácteres',
            'title.max' => 'El nombre de la comunidad debe contener máximo 50 carácteres', 
            // DESCRIPTION
            'description.required' => 'Campo obligatorio (Descripción)',
            'description.min' => 'La descripción debe contener mínimo 3 carácteres',
            'description.max' => 'La descripción debe contener máximo 500 carácteres',
            // TAGS
            'tags.required' => 'Debes escribir un mínimo de 3 tags',
            'tags.array' => 'Debes escribir un mínimo de 3 tags',
            'tags.min' => 'Debes escribir un mínimo de 3 tags',
            'tags.max' => 'Debes escribir un máximo de 20 tags',
            // TAGS (TAG)
            'tags.*.min' => 'La longitud mínima del tag es de 2 carácteres',
            'tags.*.max' => 'La longitud máxima del tag es de 20 carácteres',
            'tags.*.distinct' => 'No pueden haber tags duplicados',
            'tags.*.regex' => 'Los tags sólo pueden contener letras y números',
        ];
        $validator = Validator::make($request->all(), [
            'tag' => 'required|unique:communities,tag|min:3|max:30|regex:/^[a-zA-Z0-9]+$/',
            'title' => 'required|min:3|max:50',
            'description' => 'required|min:3|max:500',
            'tags' => 'required|array|min:3|max:20',
            'tags.*' => 'min:2|max:20|distinct|regex:/^[a-zA-Z0-9]+$/'
        ], $messages);
        if ($validator->passes()) {
            $community = Community::create([
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'tag' => $request->tag,
                'title' => $request->title,
                'description' => $request->description
            ]);
            /* Reward */
            if (UserReward::where('user_id', Auth::user()->id)->where('reward_id', '8')->doesntExist()) {
                UserReward::createUserReward(Auth::user()->id, '8');
                Notification::createNotification(Auth::user()->id, "Logro desbloqueado: La unión hace la fuerza", "reward");
            }
            /* Set Master Mod */
            UserCommunity::leaderJoinCommunity($community->id);
            /* Set Community Tags */
            foreach ($request->tags as $tagname) {
                CommunityTags::newCommunityTag($community->id, $tagname);
            }
            return response()->json(['url' => '/c/'.$request->tag]);
        } else {
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
        }  
    }

    public static function getAffiliates($community_id, $character) {
        if (!empty($character)) {
            if (is_numeric($character)) {
                $users = UserCommunity::whereIn('subscription_type', [0, 2000])->with('user')->where('community_id', $community_id)->whereHas('user', function($q) {
                    $q->where('name', 'regexp', '^[0-9]+');
                })->orderBy('subscription_type', 'desc')->paginate(30, ['*'], 'pagina');
            } else {
                $users = UserCommunity::whereIn('subscription_type', [0, 2000])->with('user')->where('community_id', $community_id)->whereHas('user', function($q) use ($character) {
                    $q->where('name', 'like', $character.'%');
                })->orderBy('subscription_type', 'desc')->paginate(30, ['*'], 'pagina');
            }
        } else {
            $users = UserCommunity::whereIn('subscription_type', [0, 2000])->with('user')->where('community_id', $community_id)->orderBy('subscription_type', 'desc')->paginate(30, ['*'], 'pagina');
        }
        return $users;
    }

}