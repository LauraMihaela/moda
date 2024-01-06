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
use App\Models\Shipment;
use App\Models\Client;
use Monarobase\CountryList\CountryListFacade;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;


class ProductsController extends Controller
{
    public function cartIndex(){
        return view('cart.index');
    }

    public function index(){
        $products = Color::all();        
        return view('dashboard.index')->with('products',$products);
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
        /*
        dump($request->all());
        $sizes = $request->input('sizes');
        $sizes = implode(',', $sizes);
        dump($sizes);
        $colors = $request->input('colors');
        $colors = implode(',', $colors);
        dump($colors);
        */
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

    
    public function show(int $id){
        
        $sizes = Size::select('sizes.id as size_id','size_name')->get();
        $colors = Color::select('colors.id as color_id','color_name')->get();
        $fashionDesigners = FashionDesigner::select('fashion_designers.id as fashion_designer_id','fashion_designers.name as name','fashion_designers.country as country')->get();
        $product = Product::find($id);
        $sizesColorsProducts = SizeColorProduct::where('product_id',$id)->get();
        $selectedSizes = SizeColorProduct::join('sizes','sizes_colors_products.size_id','sizes.id')
        ->select('size_id','size_name')->where('product_id',$id)
        ->whereNotNull('size_id')->get();
        $selectedColors = SizeColorProduct::join('colors','sizes_colors_products.color_id','colors.id')
        ->select('color_id','color_name')->where('product_id',$id)->whereNotNull('color_id')->get();
        $selectedFashionDesigners = Product::join('fashion_designers','products.created_by_fashion_designer_id','fashion_designers.id')
        ->select('created_by_fashion_designer_id as fashion_designer_id','name','country')
        ->where('products.id',$id)->get();
        // Se hace un flatten para pasar de una coleccion multidimensional a una de 1 dimension
        // Despues del flatten, se hace un diff para quedarse solamente con los elementos que no estan elegidos
        $sizes = $sizes->flatten()->diff($selectedSizes->flatten());
        $colors = $colors->flatten()->diff($selectedColors->flatten()); 
        $fashionDesigners = $fashionDesigners->flatten()->diff($selectedFashionDesigners->flatten());

        return view('products.show', compact('product', 'sizesColorsProducts', 'sizes', 'colors', 'fashionDesigners','selectedSizes','selectedColors','selectedFashionDesigners'));
    }

    public function edit(int $id){
        $sizes = Size::select('sizes.id as size_id','size_name')->get();
        $colors = Color::select('colors.id as color_id','color_name')->get();
        $fashionDesigners = FashionDesigner::select('fashion_designers.id as fashion_designer_id','fashion_designers.name as name','fashion_designers.country as country')->get();
        $product = Product::find($id);
        $sizesColorsProducts = SizeColorProduct::where('product_id',$id)->get();
        $selectedSizes = SizeColorProduct::join('sizes','sizes_colors_products.size_id','sizes.id')
        ->select('size_id','size_name')->where('product_id',$id)
        ->whereNotNull('size_id')->get();
        $selectedColors = SizeColorProduct::join('colors','sizes_colors_products.color_id','colors.id')
        ->select('color_id','color_name')->where('product_id',$id)->whereNotNull('color_id')->get();
        $selectedFashionDesigners = Product::join('fashion_designers','products.created_by_fashion_designer_id','fashion_designers.id')
        ->select('created_by_fashion_designer_id as fashion_designer_id','name','country')
        ->where('products.id',$id)->get();
        // Se hace un flatten para pasar de una coleccion multidimensional a una de 1 dimension
        // Despues del flatten, se hace un diff para quedarse solamente con los elementos que no estan elegidos
        $sizes = $sizes->flatten()->diff($selectedSizes->flatten());
        $colors = $colors->flatten()->diff($selectedColors->flatten()); 
        $fashionDesigners = $fashionDesigners->flatten()->diff($selectedFashionDesigners->flatten());
        $selectedFashionDesigner = $selectedFashionDesigners->first();
        
        
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
        $fashionDesignerArr = $selectedFashionDesigners->toArray();
        // dd($fashionDesignerArr);
        if(!empty($fashionDesignerArr)){
            foreach ($fashionDesigners as $index=>$fashionDesigner){
                if ($fashionDesigner['id'] == $fashionDesignerArr[0]['fashion_designer_id']){
                    $fashionDesigners->forget($index);
                }
            }
        }

        // dd($fashionDesigners);
        // dd($sizes->toArray());
        
        return view('products.edit', compact('product', 'sizesColorsProducts', 'sizes', 'colors', 'fashionDesigners','selectedSizes','selectedColors','selectedFashionDesigner'));
    }

    public function update(Request $request, int $id){

        // dd($request->all());
        $validatedData = $request->validate([
            'product_name' => [
                'required',
                'string',
                'max:250',               
                Rule::unique('products')->ignore($id),
            ],
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'description' => 'string',
            'units' => 'integer|nullable',
            'price' => 'numeric',
        ]);
        $product = Product::find($id);
        if(empty($product)){
            return redirect()->back()->withErrors("No se ha encontrado el producto");
        }



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
            // dump($fashion_designer);
        }

        // Si no se han escrito unidades en el campo unidades, hay 1 unidad
        if (is_null($request->units)){
            $units = 1;
        }
        else{
            $units = $request->units;
        }
        if ($request->product_name){
            $product->product_name = $request->product_name;
        }
        if (!is_null($picture)){
            $product->picture = $picture;
        }
        if ($request->description){
            $product->description = $request->description;
        }
        if (!is_null($units)){
            $product->units = $request->units;
        }
        if ($request->price){
            $product->price = $request->price;
        }
        if (!is_null($fashion_designer)){
            $product->created_by_fashion_designer_id = $fashion_designer;
        }
        $product->save();
        // dd($product->toArray());

        $sizes_colors_products = SizeColorProduct::where('product_id',$product->id)->get();

        $cont_previous_sizes = SizeColorProduct::where('product_id',$product->id)->whereNotNull('size_id')->get()->count();
        $cont_previous_colors = SizeColorProduct::where('product_id',$product->id)->whereNotNull('color_id')->get()->count();
        
        $cont_max_previous = max([$cont_previous_sizes, $cont_previous_colors]);

        $cont_sizes = 0;
        if (!is_null($request->sizes)){
            $cont_sizes = count($request->sizes);
        }  
        $cont_colors = 0;
        if (!is_null($request->colors)){
            $cont_colors = count($request->colors);
        } 
        $cont_max = max([$cont_sizes, $cont_colors]);

        if($cont_max_previous == $cont_max){
            // Si el numero de filas es el mismo, no se añaden ni eliminan filas
            // dump($request->sizes);
            foreach ($sizes_colors_products as $index=>$elem){
                // dump($elem->toArray());
                if(isset($request->colors[$index])){
                    $elem->color_id = $request->colors[$index];
                }
                else{
                    $elem->color_id = null;
                }
                if(isset($request->sizes[$index])){
                    $elem->size_id = $request->sizes[$index];
                }
                else{
                    $elem->size_id = null;
                }
                $elem->save();
                // dump($elem->toArray());
            }
            // dd(1);
        }
        else{
            // Recorremos la tabla y la eliminamos
            foreach ($sizes_colors_products as $index=>$elem){
                $elem->delete();
            }
            // Comprobar si se le ha pasado algo en el request o no
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
    

        }
        return redirect()->to('/dashboard')->with('message', 'El producto '.$request->product_name. ' ha sido actualizado');

    }

    public function destroy(int $id){
        $product = Product::find($id);
        $sizeColorProducts = SizeColorProduct::where('product_id',$id)->get();
        $productName = $product->product_name;
        if(empty($product)){
            // La función destroy devuelve un json; así se ha definido en la llamada ajax
            // El json tiene un campo estado (1: error o 0:ok) y un campo mensaje (con un texto)
            return response()->json(['status' => 1, 'message' => "El producto no se ha encontrado"]);
        }
        $product->delete($id);
        foreach ($sizeColorProducts as $index=>$elem){
            $elem->delete();
        }
        return response()->json(['status' => 0, 'message' => "El producto ".$productName. " ha sido eliminado"]);
    }

    public function addTocart(Request $request, int $id){
        // dump($id);
        // dump($request->all());
        $product = Product::find($id);
        if(empty($product)){
            // La función destroy devuelve un json; así se ha definido en la llamada ajax
            // El json tiene un campo estado (1: error o 0:ok) y un campo mensaje (con un texto)
            return response()->json(['status' => 1, 'message' => "El producto no se ha añadido al carrito"]);
        }
        $color = null;
        if($request->colors){
            $color = $request->colors;
        }
        $size = null;
        if($request->sizes){
            $size = $request->sizes;
        } 
        $productName = $product->product_name;
        $sizesColorsProduct = SizeColorProduct::where('product_id',$id)->where('color_id',$color)->where('size_id',$size)->first();
        $sizesColorsProductId = $sizesColorsProduct->id;
        // dump($sizesColorsProduct->toArray());
        // dd($sizesColorsProductId);
        $userId = auth()->user()->id;
        $client = Client::where('user_id',$userId)->first();
        $clientId = $client->id;
        // Estado inicial
        $statusId = 1;
        Shipment::create([
            'client_id' => $clientId,
            'sizes_colors_products_id' => $sizesColorsProductId,
            'status_id' => $statusId,
        ]);
        return response()->json(['status' => 0, 'message' => "El producto ".$productName. " ha sido añadido al carrito"]);

    }

    public function showProductCartDetails(int $id){
        $product = Product::find($id);
        $sizesColorsProducts = SizeColorProduct::where('product_id',$id)->get();
        $sizes = SizeColorProduct::join('sizes','sizes_colors_products.size_id','sizes.id')
        ->select('size_id','size_name')->where('product_id',$id)
        ->whereNotNull('size_id')->get();
        $colors = SizeColorProduct::join('colors','sizes_colors_products.color_id','colors.id')
        ->select('color_id','color_name')->where('product_id',$id)->whereNotNull('color_id')->get();
        return view('products.showProductCartDetails', compact('product', 'sizesColorsProducts','sizes','colors'));

    }

    public function datatable(Request $request){
        $query = Product::select('id','product_name','picture','price')->get();    

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
