<?php

namespace App\Http\Controllers\Site\Community;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReportThread;
use App\Models\ReportReply;
use App\Models\UserCommunity;
use App\Models\Thread;
use App\Models\Reply;
use Auth;

class ReportController extends Controller {

    function solveThread(Request $request) {
        $thread_id = ReportThread::where('id', $request->report_id)->value('thread_id');
        $community_id = Thread::where('id', $thread_id)->value('community_id');
        if (Thread::where('id', $thread_id)->where('community_id', $community_id)->doesntExist()) {
            return response()->json(['error' => '⚠️ Ha ocurrido un problema con tu petición (Error 500) ⚠️']);
            abort(404);
        }
        if (Auth::user()) {
            if (UserCommunity::isUserAdmin(Auth::user()->id, $community_id)) {
                ReportThread::where('id', $request->report_id)->update(['solved' => 1]);
            } else {
                return response()->json(['error' => '⚠️ Ha ocurrido un problema con tu petición (Error 500) ⚠️']); 
            }
        }
    }

    function closeThread(Request $request) {
        $thread_id = ReportThread::where('id', $request->report_id)->value('thread_id');
        $community_id = Thread::where('id', $thread_id)->value('community_id');
        if (Thread::where('id', $thread_id)->where('community_id', $community_id)->doesntExist()) {
            return response()->json(['error' => '⚠️ Ha ocurrido un problema con tu petición (Error 500) ⚠️']);
            abort(404);
        }
        if (Auth::user()) {
            if (UserCommunity::isUserAdmin(Auth::user()->id, $community_id)) {
                Thread::where('id', $thread_id)->update(['closed' => 1]);
            } else {
                return response()->json(['error' => '⚠️ Ha ocurrido un problema con tu petición (Error 500) ⚠️']); 
            }
        }
    }

    function wipeReply(Request $request) {
        $reply_id = ReportReply::where('id', $request->report_id)->value('reply_id');
        $thread_id = Reply::where('id', $reply_id)->value('thread_id');
        $community_id = Thread::where('id', $thread_id)->value('community_id');
        if (Thread::where('id', $thread_id)->where('community_id', $community_id)->doesntExist()) {
            return response()->json(['error' => '⚠️ Ha ocurrido un problema con tu petición (Error 500) ⚠️']);
            abort(404);
        }
        if (Auth::user()) {
            if (UserCommunity::isUserAdmin(Auth::user()->id, $community_id)) {
                Reply::where('id', $reply_id)->update(['text' => '<i>Mensaje eliminado</i>']);
            } else {
                return response()->json(['error' => '⚠️ Ha ocurrido un problema con tu petición (Error 500) ⚠️']); 
            }
        }
    }

    function solveReply(Request $request) {
        $reply_id = ReportReply::where('id', $request->report_id)->value('reply_id');
        $thread_id = Reply::where('id', $reply_id)->value('thread_id');
        $community_id = Thread::where('id', $thread_id)->value('community_id');
        if (Thread::where('id', $thread_id)->where('community_id', $community_id)->doesntExist()) {
            return response()->json(['error' => '⚠️ Ha ocurrido un problema con tu petición (Error 500) ⚠️']);
            abort(404);
        }
        if (Auth::user()) {
            if (UserCommunity::isUserAdmin(Auth::user()->id, $community_id)) {
                ReportReply::where('id', $request->report_id)->update(['solved' => 1]);
            } else {
                return response()->json(['error' => '⚠️ Ha ocurrido un problema con tu petición (Error 500) ⚠️']); 
            }
        }
    }
}
