<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
class UserClientController extends Controller
{
    public function index(){
        $users = User::select('id','username','name','lastname','email')->get();        
        return view('users.clients.index')->with('users',$users);
    }

    public function create(){
        return view('users.clients.create');
    }

    public function store(Request $request){
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
        // rol: 1. Client
        $role_id = config('constants.roles.client_role');

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

        return redirect()->to('/users/clients')->with('message', 'El cliente '.$request->username. ' ha sido creado');
    }

    public function show(int $id){
        // $user = User::find($id);
        $user = User::select('id','username','name','lastname','email','role_id')
        ->where('role_id',1)->where('id',$id)->first();   
        $client = Client::select('id','address','user_id')->where('user_id',$id)->first();
        return view('users.clients.show')->with('user',$user)->with('client',$client);    
    }

    public function edit(int $id){
        // $user = User::find($id);
        $user = User::select('id','username','name','lastname','email','role_id')
        ->where('role_id',1)->where('id',$id)->first();   
        $client = Client::select('id','address','user_id')->where('user_id',$id)->first();
        return view('users.clients.edit')->with('user',$user)->with('client',$client); 
    }

    public function update(Request $request, int $id){
        // dd($request->all());
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
        ]);
        
        $user = User::find($id);
        if(empty($user)){
            return redirect()->back()->withErrors("No se ha encontrado el usuario cliente");
        }

        $user->username = $request->username;
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->save();
        
        $address = null;
        if ($request->address){
            $address = $request->address;
        }
        $client = Client::select('id','address','user_id')->where('user_id',$id)->first();
        if(empty($client)){
            return redirect()->back()->withErrors("No se ha encontrado el cliente creado");
        }
        $client->address = $address;
        $client->user_id = $id;
        $client->save();

        return redirect()->to('/users/clients')->with('message', 'El usuario de tipo cliente '.$request->username. ' ha sido actualizado');

    }

    public function destroy(int $id){
        $user = User::find($id);
        $clientUsername = $user->username;
        if(empty($user)){
            return response()->json(['status' => 1, 'message' => "El usuario de tipo cliente no se ha encontrado"]);
        }
        $user->delete($id);
        return response()->json(['status' => 0, 'message' => "El cliente ".$clientUsername. " ha sido eliminado"]);
    }

    public function datatable(Request $request){
        $query = User::select('id','username','name','lastname','email','role_id')->where('role_id',1)->get();    

        $totalData = $query->count();

        $start = $request->input('start');
        $length = $request->input('length');

        $query->skip($start)->take($length);

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalData,
            'data' => $query
        ]);
    }
}
