<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(){
        return view('users.index');
    }

    public function profileIndex(){
        $client = null;
        if(auth()->user()->role_id == config('constants.roles.client_role')){
            $client = Client::where('user_id', auth()->user()->id)->first();
        }
        return view('profile.index')->with('client', $client);
    }

    public function profileUpdate(Request $request){
        // dd($request->all());
        $id = auth()->user()->id;
        $validatedData = $request->validate([
            'username' => [
                'required',
                'string',
                'max:250',               
                Rule::unique('users')->ignore($id),
            ],
            'email' => [
                'required',
                'email:rfc,dns',
                'max:250',               
                Rule::unique('users')->ignore($id),
            ],
            'name' => [
                'required',
                'string',
                'max:250',               
            ],
            'lastname' => [
                'required',
                'string',
                'max:250',               
            ],
            'password' => [
                'nullable',
                'min:7',
                'max:20',
                'regex:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.* ).{7,20}$/',
                'confirmed'  
            ],
        ]);
        
        $user = User::find($id);
        if(empty($user)){
            return redirect()->back()->withErrors("No se ha encontrado el usuario");
        }

        $user->username = $request->username;
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        if($request->password){
            // Si el usuario escribió una contraseña, se guarda hasheada
            $password = Hash::make($request->password);
            $user->password = $password;
        }
        $user->save();

        if(auth()->user()->role_id == config('constants.roles.client_role')){
            $address = null;
            if ($request->address){
                $address = $request->address;
            }
            $client = Client::select('id','address','user_id')->where('user_id',$id)->first();
            if(empty($client)){
                return redirect()->back()->withErrors("No se ha encontrado el cliente");
            }
            $client->address = $address;
            $client->user_id = $id;
            $client->save();
        }
        return redirect()->to('/dashboard')->with('message', 'El perfil de usuario ha sido actualizado');
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
        // $user_id = User::where('username',$request->username)->firstOrFail()->value('id');
        $user = User::where('username',$request->username)
        ->where('name',$request->name)
        ->where('lastname',$request->lastname)
        ->where('email',$request->email)
        ->first();
        $user_id = $user->id;

        Client::create([
            'address' => $address,
            'user_id' => $user_id
        ]);

        return redirect()->to('/')->with('message', 'El usuario '.$request->username. ' ha sido creado');
    }
}
