<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    //
    public function login(Request $request){
        
        if (!$request->has('username')){
            return back()->withErrors("El nombre de usuario o el email debe ser escrito");
        }
        $isEmail = false;
        $rules = array();
        // Se comprueba si se ha escrito un email o un username
        if(filter_var($request->username, FILTER_VALIDATE_EMAIL)){
            // Es un email
            $rules['username'] = 'required|email:rfc,dns|max:250';
            $isEmail = true;
        }
        else{
            // Es un username
            $rules['username'] = 'required';
        }
        $rules['password'] = 'required';

        $validatedData = $request->validate($rules);

        if ($isEmail){
            $username = User::where('email',$request->username)->value('username');
            if (!$username){
                return back()->withErrors("Error de autenticación");
            }
            $credentials = [
                'username' => $username,
                'password' => $request->password
            ];
        }
        else{
            $credentials = $request->only('username','password');
        }

        if (Auth::attempt($credentials)){
            // Las credenciales son correctas

            $request->session()->regenerate();
            
            // User tiene el usuario logueado actualmente
            $user = auth()->user();

            // if(Hash::needsRehash($user->password)) {
            //     $user->password = Hash::make($request->password);
            //     $user->save();
            // }
 
            return redirect()->intended('dashboard');
        }
    }

    public function logout(Request $request){
        Auth::logout();
        return redirect('/')->withErrors('Se ha cerrado la sesión.');
    }
}
