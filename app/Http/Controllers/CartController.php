<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Client;
use App\Models\Shipment;
use App\Models\Cart;
use App\Models\Size;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class CartController extends Controller
{
    public function getNumberOfProducts(){
        $user = Auth::user();

        if(is_null($user)){
            return response()->json(['status' => 1, 'message' => "El usuario no está logueado", 'numberOfShipments' => null]);
        }
        $userId = auth()->user()->id;
        $roleId = auth()->user()->role_id;
        if($roleId !== config('constants.roles.client_role')){
            return response()->json(['status' => 1, 'message' => "El usuario logueado no es un cliente", 'numberOfShipments' => null]);
        }
        $client = Client::where('user_id',$userId)->first();
        $clientId = $client->id;

        $productsInCart = Cart::where('client_id',$clientId)->get();
        // $shipments = Shipment::where('client_id',$clientId)->get();
        $numberOfProductsInCart = 0;
        // $numberOfShipments = 0;
        if ($productsInCart){
            $numberOfProductsInCart = $productsInCart->count();
        }
        return response()->json(['status' => 0, 'message' => "Hay ".$numberOfProductsInCart. " productos.", 'numberOfProductsInCart' => $numberOfProductsInCart]);
    }

    public function index(){
 
        return view('cart.index');
    }

    public function create(){
        return view('cart.create');
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'size_name' => 'required|string|max:250|unique:sizes',
        ]);
       
        Size::create([
            'size_name' => $request->size_name,
        ]);
        
        return redirect()->to('/cart')->with('message', 'El tamaño con nombre '.$request->size_name. ' ha sido creado');
    }

    public function show(int $id){
        $size = Size::find($id);
        return view('cart.show')->with('size',$size);    
    }

    public function edit(int $id){
        $size = Size::find($id);
        return view('cart.edit')->with('size',$size);   
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

        return redirect()->to('/cart')->with('message', 'El tamaño '.$request->size_name. ' ha sido actualizado');

    }

    public function destroy(int $id){
        $cartItem = Cart::find($id);
        if(empty($cartItem)){
            // La función destroy devuelve un json; así se ha definido en la llamada ajax
            // El json tiene un campo estado (1: error o 0:ok) y un campo mensaje (con un texto)
            return response()->json(['status' => 1, 'message' => "No se ha encontrado el producto del carrito"]);
        }
        $cartItem->delete($id);
        return response()->json(['status' => 0, 'message' => "Producto eliminado del carrito"]);
    }

    public function datatable(Request $request){
        // Se saca el cliente logueado
        $userId = auth()->user()->id;
        $client = Client::where('user_id',$userId)->first();  

        $query = Cart::join('sizes_colors_products','cart.sizes_colors_products_id','sizes_colors_products.id')
        ->join('products','sizes_colors_products.product_id','products.id')
        ->join('colors','sizes_colors_products.color_id','colors.id')
        ->join('sizes','sizes_colors_products.size_id','sizes.id')

        ->select(
            'cart.id as id',
            'cart.client_id as client_id','cart.sizes_colors_products_id as sizes_colors_products_id',
            'products.id as product_id','products.product_name as product_name',
            'products.picture as picture','products.price as price', 
            'colors.color_name as color_name', 'sizes.size_name as size_name',
            DB::raw('COUNT(sizes_colors_products_id) OVER (PARTITION BY sizes_colors_products_id) as number_of_units')
         )
        ->where('client_id',$client->id)
        ->distinct()
        ->get();

        // Se obtienen los valores únicos en la colección mediante unique. 
        // Se eliminan los números de cada iteracción que devuelve unique mediante value
        $query = $query->unique(function ($item)
        {
            return $item['product_name'] . $item['color_name'] . $item['size_name'];
        })->values();
        
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

    public function buyProduct(int $id, int $units){
        $cartProdcuct = Cart::find($id);
        if(empty($cartProdcuct)){
            return response()->json(['status' => 1, 'message' => "No se ha encontrado el producto del carrito"]);
        }
        if ($units < 1){
            return response()->json(['status' => 1, 'message' => "Unidades inválidas"]);
        }
        else if ($units == 1){
            $initialStatus = 1;
            Shipment::create([
                'client_id' => $cartProdcuct->client_id,
                'sizes_colors_products_id' => $cartProdcuct->sizes_colors_products_id,
                'status_id' => $initialStatus
            ]);
    
            $cartProdcuct->delete($id);
        }
        else{
            /*
            $query = Cart::join('sizes_colors_products','cart.sizes_colors_products_id','sizes_colors_products.id')
            ->join('products','sizes_colors_products.product_id','products.id')
            ->select(
                'cart.id',
                'cart.client_id as client_id','cart.sizes_colors_products_id as sizes_colors_products_id',
                'products.id as product_id','products.product_name as product_name',
                DB::raw('COUNT(sizes_colors_products_id) OVER (PARTITION BY sizes_colors_products_id) as number_of_units')
            )
            ->where('cart.id',$id)
            // ->distinct()
            ->first();
            dd($query->toArray());
            $dbUnits = $query->number_of_units;
            // Comprobamos el número de unidades para asegurarnos de que no se han escrito más de las que existen
            if ($units > $dbUnits){
                return response()->json(['status' => 1, 'message' => "Unidades inválidas"]);
            }
            else{
                */
                $initialStatus = 1;
                for($i=1; $i<=$units; $i++){
                    Shipment::create([
                        'client_id' => $cartProdcuct->client_id,
                        'sizes_colors_products_id' => $cartProdcuct->sizes_colors_products_id,
                        'status_id' => $initialStatus
                    ]);
                    $cartProdcuct->delete($id);
                }
                
            // }

        }
        
        return response()->json(['status' => 0, 'message' => "Felicidades, gracias por comprar el producto. Puedes visualizar su estado desde los pedidos."]);
    }
   
}
