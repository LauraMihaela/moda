<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProductsController extends Controller
{
    public function cartIndex(){
        return view('cart.index');
    }

    public function create(){
        return view('products.create');
    }

    public function store(Request $request){
        // dump($request->all());
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:250',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'description' => 'string',
            'units' => 'numeric|nullable',
        ]);
        if($request->picture){
            // Si no existe la carpeta, se crea
            File::makeDirectory(public_path('img'), $mode = 0755, true, true);
            $picture = $request->file('picture');
            // Nombre del fichero
            $pictureName = trim($request->product_name)."_".time() . '.' . $picture->getClientOriginalExtension();
            $picture->move(public_path('img'), $pictureName);
            // Nombre de la foto para la BD
            $picture = $pictureName;
        }
        else{
            $picture = null;
        }
        $fashion_designer = null;

        // Si no se han escrito unidades en el campo unidades, hay 1 unidad
        if (is_null($request->units)){
            $units = 1;
        }
        else{
            $units = $request->units;
        }

        Product::create([
            'product_name' => $request->product_name,
            'picture' => $picture,
            'description' => $request->description,
            'units' => $units,
            'created_by_fashion_designer_id' => $fashion_designer,
        ]);

        return redirect()->to('/dashboard')->with('message', 'El producto '.$request->product_name. ' ha sido creado');



    }

}
