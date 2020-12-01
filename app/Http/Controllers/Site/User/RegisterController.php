<?php

namespace App\Http\Controllers\Site\User;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Reward;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Mail\VerifyMail;
use App\Models\VerifyUser;
use Mail;
use DB;
use App\Models\Notification;

class RegisterController extends Controller {

	protected $redirectTo = '/index';

    public function register(Request $request) {
	            
            $messages = [

                // MAIL
                'email.required' => 'Campo vacío (Correo electrónico)',
                'email.unique' => 'El correo electrónico introducido ya está en uso',
                'email.email' => 'Debes introducir una dirección de correo válida',
                'email.min' => 'La dirección de correo debe contener mínimo 12 carácteres',
                'email.max' => 'La dirección de correo debe contener máximo 64 carácteres',
                'email.ends_with' => 'Debes introducir una dirección de correo válida',

                // NAME
                'name.required' => 'Campo vacío (Nombre de usuario)',
                'name.alpha_dash' => 'El nombre de usuario sólo puede contener letras y números',
                'name.regex' => 'El nombre de usuario sólo puede contener letras y números',
                'name.unique' => 'El nombre de usuario ya existe',
                'name.min' => 'El nombre de usuario debe contener mínimo 6 carácteres',
                'name.max' => 'El nombre de usuario debe contener máximo 20 carácteres', 

                // PASSWORD
                'password.required' => 'Campo vacío (Contraseña)',
                'password.min' => 'La contraseña debe contener mínimo 8 carácteres',
                'password.max' => 'La contraseña debe contener máximo 64 carácteres',

                // TERMS
                'terms.accepted' => 'Debes aceptar las condiciones de Forohub',
            ];

            $validator = Validator::make($request->all(), [
                'name' => 'required|alpha_dash|regex:/^[a-zA-Z0-9]+$/|unique:users,name|min:6|max:20',
                'email' => 'required|unique:users,email|min:12|max:64|ends_with:@gmail.com,@hotmail.com,@hotmail.es,@live.com,@outlook.com,@yahoo.com,@yahoo.es',
                'password' => 'required|min:8|max:64',
                'terms' => 'accepted'
            ], $messages);

            // IF VALIDATION OK
        	if ($validator->passes()) {
    			$user = User::create([
    					'name' => iconv( 'UTF-8' , 'ASCII//TRANSLIT//IGNORE' , $request->input('name')),
    			        'email' => $request->input('email'),
    			        'password' => Hash::make($request->input('password')),
    			    ]);
    			Auth::login($user);
                $verifyUser = VerifyUser::create([
                    'user_id' => $user->id,
                    'token' => sha1(time())
                  ]);
                  Mail::to($user->email)->send(new VerifyMail($user));
                  return $user;
    		} else {
        		return response()->json(['error' => $validator->getMessageBag()->toArray()]);
    		}
    
    }

    public function verifyUser($token) {

        $verifyUser = VerifyUser::where('token', $token)->first();
        
        if (isset($verifyUser)) {
            $user = $verifyUser->user;
            if (!$user->verified) {
                $verifyUser->user->verified = 1;
                $verifyUser->user->save();
                $status = "Tu cuenta ha sido verificada";
                Auth::login($user);
                /* REWARD */
                DB::table('users_rewards')->insert([
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'user_id' =>  Auth::user()->id,
                    'reward_id' => 1
                ]);
                Notification::createNotification("Logro desbloqueado: Iniciado");
                /**/
            } else {
                $status = "Tu cuenta ya ha sido verificada";
                Auth::login($user);
            }
        } else {
            return redirect('/')->with('warning', "Lo sentimos, tu cuenta no ha podido ser verificada");
        }
        return redirect('/')->with('status', $status);
    }
}
