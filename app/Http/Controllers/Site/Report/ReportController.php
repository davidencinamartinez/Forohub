<?php

namespace App\Http\Controllers\Site\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReportThread;
use App\Models\ReportReply;
use App\Models\Notification;
use App\Models\Thread;
use App\Models\Community;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Auth;

class ReportController extends Controller {

    function sendThreadReport(Request $request) {
    	if (Auth::user() && $request->ajax()) {
    		$reportList = array('Spam o Flood','Contenido violento o repulsivo','Información falsa o fraude','Acoso o Bullying','Contenido vejatorio o de incitación al odio','Contiene información confidencial y/o personal','Ventas no autorizadas','Suicidio o autolesiones','Maltrato infantil o pedofilia','Contenido de carácter terrorista');

    		$validator = Validator::make($request->all(), [
    		    'thread_id' => 'required|exists:App\Models\Thread,id',
    		    'type' => 'required|in:'.implode(',', $reportList),
    		]);

    		if ($validator->passes()) {
    			if (ReportThread::where('user_id', Auth::user()->id)->exists()) {
					$remaining_time = Carbon::now()->diffInSeconds(Carbon::parse(ReportThread::where('user_id', Auth::user()->id)->latest()->value('created_at'))->addHours(1), false);
					if ($remaining_time > 0) {
						return response()->json(['remaining_time' => $remaining_time]);
					}
				}
				ReportThread::createThreadReport($request->thread_id, $request->type, $request->description);
				$community_id = Thread::where('id', $request->thread_id)->value('community_id');
				$community = Community::where('id', $community_id)->with('community_moderators')->first();

				foreach ($community->community_moderators as $admin) {
					Notification::createNotification($admin->user_id, $request->thread_id, "thread_report");	
				}
				return response()->json(['success' => 'Tu reporte se ha enviado con éxito']);
    		} else {
    			return response()->json(['response' => 'Ha ocurrido un problema (Error 500)']);
    		}	
    	} else {
    		abort(404);
    	}
    }

    function sendReplyReport(Request $request) {

    	if (Auth::user() && $request->ajax()) {
    		$reportList = array('Spam o Flood','Troll','Información falsa','Acoso o Bullying','Información confidencial y/o personal','Racismo o Sexismo');

    		$validator = Validator::make($request->all(), [
    		    'reply_id' => 'required|exists:App\Models\Reply,id',
    		    'type' => 'required|in:'.implode(',', $reportList),
    		]);

    		if ($validator->passes()) {
    			if (ReportReply::where('user_id', Auth::user()->id)->exists()) {
					$remaining_time = Carbon::now()->diffInSeconds(Carbon::parse(ReportReply::where('user_id', Auth::user()->id)->latest()->value('created_at'))->addMinutes(10), false);
					if ($remaining_time > 0) {
						return response()->json(['remaining_time' => $remaining_time]);
					}
				}
				ReportReply::createReplyReport($request->reply_id, $request->type, $request->description);
				return response()->json(['success' => 'Tu reporte se ha enviado con éxito']);
    		} else {
    			return response()->json(['response' => 'Ha ocurrido un problema (Error 500)']);
    		}	
    	} else {
    		abort(404);
    	}    	
    }
}
