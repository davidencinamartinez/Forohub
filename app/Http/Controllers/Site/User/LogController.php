<?php

namespace App\Http\Controllers\Site\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Carbon;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Redirect;
use Session;

class LogController extends Controller
{

	public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    protected function login(Request $request) {

        Session::flush();

    	$request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->except(['_token']);

        $user = User::where('name',$request->name)->first();

        if (auth()->attempt($credentials)) {
            Auth::user($user)->fresh();
            return Redirect::back();

        } else {
            session()->flash('err', 'Invalid credentials');
            return redirect()->back()->with('err', 'Nombre de usuario y/o contraseña incorrectos');
        }
        
        
    }

     protected function logout() {
        Auth::logout();
        Session::flush();
        return Redirect::route('index');
    }
}
