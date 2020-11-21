<?php

namespace App\Http\Controllers\Auth;

use Mail;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function checkRegister(Request $request) {

        if ($request->ajax()) {

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
                'password.required' => 'Campo obligatorio (Contraseña)',
                'password.min' => 'La contraseña debe contener mínimo 8 carácteres',
                'password.max' => 'La contraseña debe contener máximo 64 carácteres',

                // TERMS
                'terms.accepted' => 'Debes aceptar las condiciones de ForoHub',

            ];

            $validator = Validator::make($request->all(), [
                'name' => 'required|alpha_dash|regex:/^[a-zA-Z0-9]+$/|unique:users,name|min:6|max:20',
                'email' => 'required|unique:users,email|min:12|max:64|ends_with:@gmail.com,@hotmail.com,@hotmail.es,@live.com,@outlook.com,@yahoo.com,@yahoo.es',
                'password' => 'required|min:8|max:64',
                'terms' => 'accepted'
            ], $messages);

            return response()->json(['error' =>$validator->getMessageBag()->toArray()]);
        } else {
            return response()->json(['error' => 'Conexión rechazada por el servidor (500)']);
        }

        return response()->json(['error' => 'Conexión rechazada por el servidor (500)']);

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {

        return Validator::make($data, [
            'name' => ['required', 'alpha_dash', 'regex:/^[a-zA-Z0-9]+$/', 'unique:users,name', 'min:6', 'max:20'],
            'email' => ['required', 'unique:users,email', 'min:12', 'max:64', 'ends_with:@gmail.com,@hotmail.com,@hotmail.es,@live.com,@outlook.com,@yahoo.com,@yahoo.es'],
            'password' => ['required', 'min:8', 'max:64'],
            'terms' => ['required|in:1']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => iconv( 'UTF-8' , 'ASCII//TRANSLIT//IGNORE' , $data['name']),
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
