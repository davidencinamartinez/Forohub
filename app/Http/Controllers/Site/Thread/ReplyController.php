<?php

namespace App\Http\Controllers\Site\Thread;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reply;
use App\Models\Notification;
use App\Models\UserReward;
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
    				$remaining_time = Carbon::now()->diffInSeconds(Carbon::parse(Reply::where('user_id', Auth::user()->id)->latest()->value('created_at'))->addMinutes(1), false);
    				if ($remaining_time > 0) {
    					return response()->json(['remaining_time' => $remaining_time]);
    				}
    			}
                if (empty($request->text)) {
                    return response()->json(['empty' => 'El mensaje no puede estar vacío']);
                }
                Reply::createReply($request->thread_id, preg_replace('/#([0-9]+)/', '<div class="thread-reply-quoted"><a href="$0">$0</a></div>', $request->text));
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
