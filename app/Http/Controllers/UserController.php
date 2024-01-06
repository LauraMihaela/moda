<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(){
        return view('users.index');
    }

    public function profileIndex(){
        return view('profile.index');
    }

    public function storeClient(Request $request){
        // dd($request->all());
        $validatedData = $request->validate([
            'username' => 'required|string|max:250|unique:users',
            'email' => 'required|email:rfc,dns|max:250|unique:users',
            'name' => 'required|string|max:250',
            'lastname' => 'required|string|max:250',
            'password' => [
                'required',
                'min:7',
                'max:20',
                'regex:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.* ).{7,20}$/',
                'confirmed'
            ],
        ]);

        $remember_token = null;
        // rol: 1. Cliente
        $role_id = 1;


        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'remember_token' => $remember_token,
            'role_id' => $role_id,
        ]);

        $address = null;
        if ($request->address){
            $address = $request->address;
        }
        // User_id que acaba de ser creado
        $user_id = User::where('username',$request->username)->firstOrFail()->value('id');
        
        Client::create([
            'address' => $address,
            'user_id' => $user_id
        ]);

        return redirect()->to('/')->with('message', 'El usuario '.$request->username. ' ha sido creado');
    }
}
