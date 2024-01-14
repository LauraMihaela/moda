<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;
use App\Models\User;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class UserAdminController extends Controller
{
    public function index(){
        $users = User::select('id','username','name','lastname','email')->get();        
        return view('users.admin.index')->with('users',$users);
    }

    public function create(){
        return view('users.admin.create');
    }

    // public function store(Request $request){
    //     $validatedData = $request->validate([
    //         'color_name' => 'required|string|max:250|unique:colors',
    //     ]);
       
    //     Color::create([
    //         'color_name' => $request->color_name,
    //     ]);
        
    //     return redirect()->to('/colors')->with('message', 'El color '.$request->color_name. ' ha sido creado');
    // }

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
        // rol: 3. Admin
        $role_id = config('constants.roles.admin_role');

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'remember_token' => $remember_token,
            'role_id' => $role_id,
        ]);

        return redirect()->to('/users/admins')->with('message', 'El usuario administrador '.$request->username. ' ha sido creado');
    }

    public function show(int $id){
        // $admin = User::find($id);
        $admin = User::select('id','username','name','lastname','email','role_id')
        ->where('role_id',3)->where('id',$id)->first();    

        return view('users.admin.show')->with('admin',$admin);    
    }

    public function edit(int $id){
        // $admin = User::find($id);
        $admin = User::select('id','username','name','lastname','email','role_id')
        ->where('role_id',3)->where('id',$id)->first();   
        return view('users.admin.edit')->with('admin',$admin);   
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
        
        $admin = User::find($id);
        if(empty($admin)){
            return redirect()->back()->withErrors("No se ha encontrado el usuario administrador");
        }

        $admin->username = $request->username;
        $admin->name = $request->name;
        $admin->lastname = $request->lastname;
        $admin->email = $request->email;
        $admin->save();

        return redirect()->to('/users/admins')->with('message', 'El usuario de tipo administrador '.$request->username. ' ha sido actualizado');

    }

    public function destroy(int $id){
        $admin = User::find($id);
        $adminUsername = $admin->username;
        if(empty($admin)){
            return response()->json(['status' => 1, 'message' => "El usuario de tipo administrador no se ha encontrado"]);
        }
        $admin->delete($id);
        return response()->json(['status' => 0, 'message' => "El usuario ".$adminUsername. " ha sido eliminado"]);
    }

    public function datatable(Request $request){
        $query = User::select('id','username','name','lastname','email','role_id')->where('role_id',3)->get();    

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
