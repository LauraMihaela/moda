<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Size;

class SizesController extends Controller
{
    public function index(){
        $sizes = Size::select('id','size_name')->get();        
        return view('sizes.index')->with('sizes',$sizes);
    }

    public function create(){
        return view('sizes.create');
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'size_name' => 'required|string|max:250|unique:sizes',
        ]);
       
        Size::create([
            'size_name' => $request->size_name,
        ]);
        
        return redirect()->to('/sizes')->with('message', 'El tamaño con nombre '.$request->size_name. ' ha sido creado');
    }

    public function show(int $id){
        $size = Size::find($id);
        return view('sizes.show')->with('size',$size);    
    }

    public function edit(int $id){
        $size = Size::find($id);
        return view('sizes.edit')->with('size',$size);   
    }

    public function update(Request $request, int $id){
        $validatedData = $request->validate([
            'size_name' => 'required|string|max:250|unique:sizes',
        ]);
        $size = Size::find($id);
        if(empty($size)){
            return redirect()->back()->withErrors("No se ha encontrado el tamaño");
        }

        $size->size_name = $request->size_name;
        $size->save();

        return redirect()->to('/sizes')->with('message', 'El tamaño '.$request->size_name. ' ha sido actualizado');

    }

    public function destroy(int $id){
        $size = Size::find($id);
        $sizeName = $size->size_name;
        if(empty($size)){
            // La función destroy devuelve un json; así se ha definido en la llamada ajax
            // El json tiene un campo estado (1: error o 0:ok) y un campo mensaje (con un texto)
            return response()->json(['status' => 1, 'message' => "El tamaño no se ha encontrado"]);
        }
        $size->delete($id);
        // return $this->jsonResponse(0, "El tamaño ".$sizeName. " ha sido eliminado");
        return response()->json(['status' => 0, 'message' => "El tamaño ".$sizeName. " ha sido eliminado"]);
    }

    public function datatable(Request $request){
        $query = Size::select('id','size_name')->get();    

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
