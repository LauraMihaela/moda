<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function index(){
        $categories = Category::select('id','category_name')->get();        
        return view('categories.index')->with('categories',$categories);
    }

    public function create(){
        return view('categories.create');
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'category_name' => 'required|string|max:250|unique:categories',
        ]);
       
        Category::create([
            'category_name' => $request->category_name,
        ]);
        
        return redirect()->to('/categories')->with('message', 'La categoría '.$request->category_name. ' ha sido creada');
    }

    public function show(int $id){
        $category = Category::find($id);
        return view('categories.show')->with('category',$category);    
    }

    public function edit(int $id){
        $category = Category::find($id);
        return view('categories.edit')->with('category',$category);   
    }

    public function update(Request $request, int $id){
        $validatedData = $request->validate([
            'category_name' => 'required|string|max:250|unique:categories',
        ]);
        $category = Category::find($id);
        if(empty($category)){
            return redirect()->back()->withErrors("No se ha encontrado la categoría");
        }

        $category->category_name = $request->category_name;
        $category->save();

        return redirect()->to('/categories')->with('message', 'La categoría '.$request->category_name. ' ha sido actualizada');

    }

    public function destroy(int $id){
        $category = Category::find($id);
        $categoryName = $category->category_name;
        if(empty($category)){
            return response()->json(['status' => 1, 'message' => "La categoría no se ha encontrado"]);
        }
        $category->delete($id);
        return response()->json(['status' => 0, 'message' => "La categoría ".$categoryName. " ha sido eliminada"]);
    }

    public function datatable(Request $request){
        $query = Category::select('id','category_name')->get();    

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


