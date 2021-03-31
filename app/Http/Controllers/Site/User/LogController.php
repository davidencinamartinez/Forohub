<?php

namespace App\Http\Controllers\Site\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FailedAuthAttempt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Carbon;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Redirect;
use Session;

class LogController extends Controller {

	public function __construct() {
        $this->middleware('guest')->except('logout');
    }


    protected function login(Request $request) {

        $ip = User::getClientIPAddress($request);

        $attempts = FailedAuthAttempt::where('ip_address', $ip)
        ->whereBetween('created_at', [Carbon::now()->subMinutes(30), Carbon::now()])
        ->get();

        if ($attempts->count() > 4) {
            $remaining_time = Carbon::now()->diffInMinutes(Carbon::parse($attempts->first()->value('created_at'))->addMinutes(31), false);
            return redirect()->back()->with('err', 'Se ha rechazado tu solicitud. Vuelve a intentarlo en '.$remaining_time.' minuto(s)');
        }

        Session::flush();

        $credentials = $request->except(['_token']);

        $user = User::where('name',$request->name)->first();

        if (auth()->attempt($credentials)) {
            Auth::user($user)->fresh();
            FailedAuthAttempt::where('ip_address', $ip)->delete();
            return Redirect::back();

        } else {
            FailedAuthAttempt::createFailedAuthAttempt($request);
            session()->flash('err', 'Invalid credentials');
            if ($attempts->count() == 4) {
                $remaining_time = Carbon::now()->diffInMinutes(Carbon::parse($attempts->first()->value('created_at'))->addMinutes(31), false);
                return redirect()->back()->with('err', 'Se ha rechazado tu solicitud. Vuelve a intentarlo en '.$remaining_time.' minuto(s)');
            }
            return redirect()->back()->with('err', 'Usuario o contraseña incorrectos. Intentos restantes: '.(5-($attempts->count()+1)));
        }
    }

    protected function logout() {
        Auth::logout();
        Session::flush();
        return Redirect::route('index');
    }
}
