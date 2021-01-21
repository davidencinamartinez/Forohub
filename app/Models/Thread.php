<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\ThreadTags;
use App\Models\PollOption;
use Auth;

class Thread extends Model {

    use HasFactory;

    protected $fillable = [
        'created_at',
        'updated_at',
        'community_id',
        'user_id',
        'title',
        'spoiler',
        'nsfw',
        'important',
        'body'
    ];

    protected $table = 'threads';

    public function communities() {
    	return $this->belongsTo(Community::class, 'community_id');
    }

    public function author() {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function replies() {
    	return $this->hasMany(Reply::class);
    }

    public function first_reply() {
        return $this->hasMany(Reply::class)->oldest();
    }

    public function votes() {
        return $this->hasMany(Vote::class);
    }

    public function upvotes() {
        return $this->hasMany(Vote::class, 'thread_id')->where('vote_type', 1);
    }

    public function downvotes() {
        return $this->hasMany(Vote::class, 'thread_id')->where('vote_type', 0);
    }

    public static function createThread($request) {
        $validator = Validator::make($request->all(), [
            'community' => 'required|exists:communities,tag',
            'title' => 'required|max:300',
            'type' => 'required|in:post,multimedia,youtube,poll',
            'tags' => 'required|array|min:2|max:20',
            'tags.*' => 'min:3|max:20|regex:/^[a-zA-Z0-9]+$/'
        ]);
        if ($validator->passes()) {
            if ($request->type == "post") {
                $validateBody = Validator::make($request->all('post'), [
                    'post' => 'required|min:10|max:20000'
                ]);
            } elseif ($request->type == "multimedia") {
                $validateBody = Validator::make($request->all('files'), [
                    'files' => 'required|min:1|max:10',
                    'files.*' =>'max:20480|mimes:jpg,jpeg,png,gif,webp,svg,mp4,webm,ogg'
                ]);
            } elseif ($request->type == "youtube") {
                $validateBody = Validator::make($request->all('link'), [
                    'link' => 'required|size:11|alpha_dash'
                ]);
            } elseif ($request->type == "poll") {
                $validateBody = Validator::make($request->all('options'), [
                    'options' => 'required|array|min:2|max:10',
                    'options.*' => 'required|max:50|alpha_dash',
                ]);
            }
            if (!$validateBody->passes()) {
                abort(404);
            }
        } else {
            abort(404);
        }
        Thread::createPostThread($request);
        return $request->all();
    }

    public static function createPostThread($request) {
        $community_id = Community::where('tag', $request->community)->value('id');
        $body;
        if ($request->type == "post") {
            $body = strip_tags($request->post);
        }
        if ($request->type == "multimedia") {
            $urlArray = [];
            if (count($request->file('files')) == 1) {
                $mimeImages = array("image/jpg", "image/jpeg", "image/png", "image/gif", "image/webp", "image/svg");
                $mimeVideos = array("video/mp4", "video/webm");
                $filetype = $request->file('files.0')->getMimeType();
                if (in_array($filetype, $mimeImages)) {
                    $upload = cloudinary()->upload($request->file('files.0')->getRealPath())->getSecurePath();
                    if ($request->exists('check_nsfw')) {
                        $body = '<div class="picture blurry"><img src="'.$upload.'"></div>';
                    } else {
                        $body = '<div class="picture"><img src="'.$upload.'"></div>';
                    }
                } elseif (in_array($filetype, $mimeVideos)) {
                    $upload = cloudinary()->uploadVideo($request->file('files.0')->getRealPath())->getSecurePath();
                    if ($request->exists('check_nsfw')) {
                        $body = '<div class="media-frame blurry"><video preload="meta" controls src="'.$upload.'"></div>';
                    } else {
                        $body = '<div class="media-frame"><video preload="meta" controls src="'.$upload.'"></div>';
                    }

                }
            } else {
                for ($i = 0; $i < count($request->file('files')); $i++) {
                    $upload = cloudinary()->upload($request->file('files')[$i]->getRealPath())->getSecurePath();
                    array_push($urlArray, $upload);
                }
                $body = '<div class="slideshow-content" data-source="';
                $body .= implode(",", $urlArray);
                $body .= '"><div class="slideshow-media"><img src="'.$urlArray[0].'" data-id="0"></div><a class="slide-previous">❮</a><a class="slide-next">❯</a><label class="slideshow-page">1/'.count($_FILES).'</label></div>';
            }
            if (trim($request->input('caption')) != '' || trim($request->input('caption')) != null) {
                $body .= '<marquee behavior="scroll" direction="left" scrollamount="10" onmouseover="stop()" onmouseleave="start()">'.strip_tags($request->caption).'</marquee>';
            }
        }
        if ($request->type == "youtube") {
            $body = '<div class="media-embed"><iframe width="560" height="315" src="https://www.youtube.com/embed/'.$request->link.'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe></div>';
        }
        if ($request->type == "poll") {
            $body = 'IS_POLL';
        }
        Thread::create([
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'community_id' => $community_id,
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'spoiler' => intval(boolval($request->check_spoiler)),
            'nsfw' => intval(boolval($request->check_nsfw)),
            'important' => intval(boolval($request->check_important)),
            'body' => $body
        ]);
        $thread_id = Thread::latest()->value('id');
        ThreadTags::createThreadTags($thread_id, $request->tags);
        if ($request->type == "poll") {
            foreach ($request->options as $poll_option) {
                PollOption::createPollOption($thread_id, strip_tags($poll_option));
            }
        }
    }
}
