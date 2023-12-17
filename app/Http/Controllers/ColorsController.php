<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;

class ColorsController extends Controller
{
    public function index(){
        $colors = Color::select('id','color_name')->get();        
        return view('colors.index')->with('colors',$colors);
    }

    public function create(){
        return view('colors.create');
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'color_name' => 'required|string|max:250|unique:colors',
        ]);
       
        Color::create([
            'color_name' => $request->color_name,
        ]);
        
        return redirect()->to('/colors')->with('message', 'El color '.$request->color_name. ' ha sido creado');
    }

    public function show(int $id){
        $color = Color::find($id);
        return view('colors.show')->with('color',$color);    
    }

    public function edit(int $id){
        $color = Color::find($id);
        return view('colors.edit')->with('color',$color);   
    }

    public function update(Request $request, int $id){
        $validatedData = $request->validate([
            'color_name' => 'required|string|max:250|unique:colors',
        ]);
        $color = Color::find($id);
        if(empty($color)){
            return redirect()->back()->withErrors("No se ha encontrado el color");
        }

        $color->color_name = $request->color_name;
        $color->save();

        return redirect()->to('/colors')->with('message', 'El color '.$request->color_name. ' ha sido actualizado');

    }

    public function destroy(int $id){
        $color = Color::find($id);
        $colorName = $color->color_name;
        if(empty($color)){
            // La función destroy devuelve un json; así se ha definido en la llamada ajax
            // El json tiene un campo estado (1: error o 0:ok) y un campo mensaje (con un texto)
            return response()->json(['status' => 1, 'message' => "El color no se ha encontrado"]);
        }
        $color->delete($id);
        // return $this->jsonResponse(0, "El color ".$colorName. " ha sido eliminado");
        return response()->json(['status' => 0, 'message' => "El color ".$colorName. " ha sido eliminado"]);
    }

    public function datatable(Request $request){
        $query = Color::select('id','color_name')->get();    

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

