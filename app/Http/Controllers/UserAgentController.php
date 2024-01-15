<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserAgentController extends Controller
{
    public function index(){
        $users = User::select('id','username','name','lastname','email')->get();        
        return view('users.agents.index')->with('users',$users);
    }

    public function create(){
        return view('users.agents.create');
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
        // rol: 2. agent
        $role_id = config('constants.roles.agent_role');

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'remember_token' => $remember_token,
            'role_id' => $role_id,
        ]);

        return redirect()->to('/users/agents')->with('message', 'El usuario de tipo agente '.$request->username. ' ha sido creado');
    }

    public function show(int $id){
        // $agent = User::find($id);
        $agent = User::select('id','username','name','lastname','email','role_id')
        ->where('role_id',2)->where('id',$id)->first();    

        return view('users.agents.show')->with('agent',$agent);    
    }

    public function edit(int $id){
        // $agent = User::find($id);
        $agent = User::select('id','username','name','lastname','email','role_id')
        ->where('role_id',2)->where('id',$id)->first();   
        return view('users.agents.edit')->with('agent',$agent);   
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
        
        $agent = User::find($id);
        if(empty($agent)){
            return redirect()->back()->withErrors("No se ha encontrado el usuario agente");
        }

        $agent->username = $request->username;
        $agent->name = $request->name;
        $agent->lastname = $request->lastname;
        $agent->email = $request->email;
        $agent->save();

        return redirect()->to('/users/agents')->with('message', 'El usuario de tipo agente '.$request->username. ' ha sido actualizado');

    }

    public function destroy(int $id){
        $agent = User::find($id);
        $agentUsername = $agent->username;
        if(empty($agent)){
            return response()->json(['status' => 1, 'message' => "El usuario de tipo agente no se ha encontrado"]);
        }
        $agent->delete($id);
        return response()->json(['status' => 0, 'message' => "El usuario ".$agentUsername. " ha sido eliminado"]);
    }

    public function datatable(Request $request){
        $query = User::select('id','username','name','lastname','email','role_id')->where('role_id',2)->get();    

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
