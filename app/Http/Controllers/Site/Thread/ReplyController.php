<?php

namespace App\Http\Controllers\Site\Thread;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reply;
use App\Models\Notification;
use App\Models\UserReward;
use App\Models\Community;
use App\Models\Thread;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Validator;

class ReplyController extends Controller {

	/* CREATE REPLY */

    function makeReply(Request $request) {
        $request->text = strip_tags($request->text);
    	if (Auth::user()) {
      		$messages = [
    			// THREAD ID
    			'thread_id.required' => 'Ha ocurrido un problema (Error 404)',
    			'thread_id.numeric' => 'Ha ocurrido un problema (Error 404)',
    			'thread_id.exists' => 'Ha ocurrido un problema (Error 404)',
    			// TEXT
                'text.required' => 'El mensaje no puede estar vacío',
                'text.string' => 'Sólo se permiten carácteres alfanuméricos',
                'text.filled' => 'El mensaje no puede estar vacío',
                'text.min' => 'El mensaje no puede estar vacío',
                'text.max' => 'Sólo puedes escribir un máximo de 3000 carácteres. Has escrito: '.strlen($request->text),
            ];

            $validator = Validator::make($request->all(), [
                'thread_id' => 'required|numeric|exists:threads,id',
                'text' => 'required|string|filled|min:1|max:3000',
            ], $messages);

            if ($validator->passes()) {
    			if (Reply::where('user_id', Auth::user()->id)->exists()) {
    				$remaining_time = Carbon::now()->diffInSeconds(Carbon::parse(Reply::where('user_id', Auth::user()->id)->latest()->value('created_at'))->addSeconds(30), false);
    				if ($remaining_time > 0) {
    					return response()->json(['remaining_time' => $remaining_time]);
    				}
    			}
                if (empty($request->text)) {
                    return response()->json(['empty' => 'El mensaje no puede estar vacío']);
                }
                // THREAD REFERENCE
                $request->text = preg_replace_callback('/@[a-zA-Z0-9]{0,20}/', function ($matches) {
                    $user = str_replace('@', '', $matches[0]);
                    $string = '<a href="/u/'.strtolower($user).'">'.$matches[0].'</a>';
                    return $string;
                }, $request->text);
                $community_id = Thread::where('id', $request->thread_id)->value('community_id');
                $community_tag = Community::where('id', $community_id)->value('tag');
                $thread_replies = Reply::where('thread_id', $request->thread_id)->with('user:id,name')->get(['id', 'user_id', 'text']);
                Reply::createReply($request->thread_id, preg_replace_callback('/#([0-9]+)/', 
                    function ($matches) use ($request, $community_id, $community_tag, $thread_replies) {
                        $quote_page = 0;
                        $quote_user;
                        $quote_text;
                        foreach ($thread_replies as $reply) {
                            if ($reply->id == $matches[1]) {
                                $quote_user = $reply->user->name;
                                $quote_text = $reply->text;
                                break;
                            } else {
                                $quote_page = $quote_page+0.1;
                            }
                        }
                        $string = '<div class="thread-quote"><div class="thread-quote-info"><b>Escrito por <a href="/u/'.strtolower($quote_user).'">'.$quote_user.'</a>&nbsp;<a href="/c/'.$community_tag.'/t/'.$request->thread_id.'?pagina='.ceil($quote_page).$matches[0].'">➤</a></b></div><div class="thread-quote-data">'.$quote_text.'</div></div>';
                        return $string;
                }, $request->text));
                Reply::mentionUser($request->text, $request->thread_id);
            	// REWARDS
    			$user_reply_count = Reply::where('user_id', Auth::user()->id)->count();
    			if ($user_reply_count == 1) {
    				UserReward::createUserReward(Auth::user()->id, '2');
    				Notification::createNotification(Auth::user()->id, "Logro desbloqueado: ¡Buen viaje!", "reward");
    			} elseif ($user_reply_count == 100) {
    				UserReward::createUserReward(Auth::user()->id, '3');
    				Notification::createNotification(Auth::user()->id, "Logro desbloqueado: Paso a paso", "reward");
    			} elseif ($user_reply_count == 500) {
    				UserReward::createUserReward(Auth::user()->id, '4');
    				Notification::createNotification(Auth::user()->id, "Logro desbloqueado: Voy a tope!", "reward");
    			} elseif ($user_reply_count == 1000) {
    				UserReward::createUserReward(Auth::user()->id, '5');
    				Notification::createNotification(Auth::user()->id, "Logro desbloqueado: Gas Gas Gas", "reward");
    			} elseif ($user_reply_count == 10000) {
    				UserReward::createUserReward(Auth::user()->id, '6');
    				Notification::createNotification(Auth::user()->id, "Logro desbloqueado: Sayonara, Baby", "reward");
    			} elseif ($user_reply_count == 50000) {
    				UserReward::createUserReward(Auth::user()->id, '7');
    				Notification::createNotification(Auth::user()->id, "Logro desbloqueado: Interstellar", "reward");
    			}
            	return response()->json([
            		'success' => 'Mensaje enviado con éxito 🗸',
            	]);
            } else {
            	return response()->json(['error' => $validator->getMessageBag()->toArray()]);
	        }
    	} else {
    		return response()->json(['response' => 'Ha ocurrido un problema (Error 500)']);
    	}
    }
}
