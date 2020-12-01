<?php

namespace App\Http\Controllers\Site\Thread;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reply;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Validator;

class ReplyController extends Controller {

	/* CREATE REPLY */

    function createReply(Request $request) {
    	if (Auth::user()) {
      		$messages = [
    			// THREAD ID
    			'thread_id.required' => 'Ha ocurrido un problema (Error 404)',
    			'thread_id.numeric' => 'Ha ocurrido un problema (Error 404)',
    			'thread_id.exists' => 'Ha ocurrido un problema (Error 404)',
    			// TEXT
                'text.required' => 'El mensaje no puede estar vacío',
                'text.string' => 'Sólo se permiten carácteres alfanuméricos',
                'text.min' => 'El mensaje no puede estar vacío',
                'text.max' => 'Sólo puedes escribir un máximo de 3000 carácteres. Has escrito: '.strlen($request->text),
            ];

            $validator = Validator::make($request->all(), [
                'thread_id' => 'required|numeric|exists:threads,id',
                'text' => 'required|string|min:1|max:3000',
            ], $messages);

            if ($validator->passes()) {
    			if (Reply::where('user_id', Auth::user()->id)->exists()) {
    				$remaining_time = Carbon::now()->diffInSeconds(Carbon::parse(Reply::where('user_id', Auth::user()->id)->latest()->value('created_at'))->addMinutes(1), false);
    				if ($remaining_time > 0) {
    					return response()->json(['remaining_time' => $remaining_time]);
    				}
    			}
            	Reply::create([
            		'created_at' => Carbon::now(),
            		'updated_at' => Carbon::now(),
            		'thread_id' => $request->thread_id,
            		'user_id' => Auth::user()->id,
            		'text' => $request->text
            	]);
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
