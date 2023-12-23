<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\SizeColorProduct;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\FashionDesigner;
use App\Models\Size;
use App\Models\Color;
use Monarobase\CountryList\CountryListFacade;

class ProductsController extends Controller
{
    public function cartIndex(){
        return view('cart.index');
    }

    public function create(){
        // Se obtienen todos los elementos de la tabla fashion designers
        $fashionDesigners= FashionDesigner::get();
        // Se convierte el resultado a array para luego comprobar si es vacío
        $fashionDesignersArray = $fashionDesigners->toArray();
        if (!$fashionDesignersArray){
            // Si no hay elementos, se asigna un null
            $fashionDesigners = null;
        }
        else{
            $fashionDesigners = $fashionDesigners->map(function ($designer){
                return [
                    'id' => $designer->id,
                    'name' => $designer->name,
                    'country' => $designer->country,
                    // A partir de la libería, con el nombre del país en la BD, se obtiene el nombre largo del país
                    'longCountry' => CountryListFacade::getOne($designer->country,'es')
                ];
            });
        }
        $sizes = Size::all();
        $colors = Color::all();

        // dd($fashionDesigners->toArray());
           // 'fashionDesigners' es el nombre de la variable que se va a utilizar en view
        return view('products.create')->with('fashionDesigners',$fashionDesigners)
        ->with('sizes',$sizes)->with('colors',$colors);
    }

    public function store(Request $request){
        dump($request->all());
        $sizes = $request->input('sizes');
        $sizes = implode(',', $sizes);
        dump($sizes);
        $colors = $request->input('colors');
        $colors = implode(',', $colors);
        dump($colors);

        $validatedData = $request->validate([
            'product_name' => 'required|string|max:250',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'description' => 'string',
            'units' => 'integer|nullable',
            'price' => 'numeric',
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
        if (!is_null($request->fashionDesigner)){
            $fashion_designer = FashionDesigner::find($request->fashionDesigner);
            $fashion_designer = $fashion_designer->id;
        }

        // Si no se han escrito unidades en el campo unidades, hay 1 unidad
        if (is_null($request->units)){
            $units = 1;
        }
        else{
            $units = $request->units;
        }

        $product = Product::create([
            'product_name' => $request->product_name,
            'picture' => $picture,
            'description' => $request->description,
            'units' => $units,
            'price' => $request->price,
            'created_by_fashion_designer_id' => $fashion_designer,
        ]);

        $cont_sizes = 0;
        if (!is_null($request->sizes)){
            $cont_sizes = count($request->sizes);
        }  
        $cont_colors = 0;
        if (!is_null($request->colors)){
            $cont_colors = count($request->colors);
        } 
        if(is_null($request->sizes)&&is_null($request->colors)){
            // Solo se inserta con un elemento en la tabla sizes_colors_products, porque los colores y tamaños estan vacios
            SizeColorProduct::create([
                'product_id' => $product->id,
                'color_id' => null,
                'size_id' => null,
            ]);
        }
        else if ($cont_sizes == $cont_colors){
            // Se insertan tantos elementos como haya en tamaños y colores. Ninguno estará a null
            for($num_elementos=0; $num_elementos<$cont_sizes; $num_elementos++){
                SizeColorProduct::create([
                    'product_id' => $product->id,
                    'color_id' => $request->colors[$num_elementos],
                    'size_id' => $request->sizes[$num_elementos],
                ]);
            }
        }
        else if ($cont_sizes > $cont_colors){
            // Hay más tamaños que colores: se insertan los tamaños y colores, 
            // hasta que se llegue al limite de colores, entonces se insertan null de colores
            foreach ($request->colors as $key => $value){
                SizeColorProduct::create([
                    'product_id' => $product->id,
                    'color_id' => $request->colors[$key],
                    'size_id' => $request->sizes[$key],
                ]);
            }
            for($num_elementos=$key+1; $num_elementos<$cont_sizes; $num_elementos++){
                SizeColorProduct::create([
                    'product_id' => $product->id,
                    'color_id' => null,
                    'size_id' => $request->sizes[$num_elementos],
                ]);
            }
        }
        else if ($cont_sizes < $cont_colors){
            // Más colores que tamaños
            foreach ($request->sizes as $key => $value){
                SizeColorProduct::create([
                    'product_id' => $product->id,
                    'color_id' => $request->colors[$key],
                    'size_id' => $request->sizes[$key],
                ]);
            }
            for($num_elementos=$key+1; $num_elementos<$cont_colors; $num_elementos++){
                SizeColorProduct::create([
                    'product_id' => $product->id,
                    'color_id' => $request->colors[$num_elementos],
                    'size_id' => null
                ]);
            }
        }

        return redirect()->to('/dashboard')->with('message', 'El producto '.$request->product_name. ' ha sido creado');



    }

}
