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
        // Se saca el cliente logueado
        $userId = auth()->user()->id;
        $client = Client::where('user_id',$userId)->first();  

        $query = Cart::join('sizes_colors_products','cart.sizes_colors_products_id','sizes_colors_products.id')
        ->join('products','sizes_colors_products.product_id','products.id')
        ->join('colors','sizes_colors_products.color_id','colors.id')
        ->join('sizes','sizes_colors_products.size_id','sizes.id')

        ->select(
            'cart.client_id as client_id','cart.sizes_colors_products_id as sizes_colors_products_id',
            'products.id as product_id','products.product_name as product_name',
            'products.picture as picture','products.price as price', 
            'colors.color_name as color_name', 'sizes.size_name as size_name',
            DB::raw('COUNT(sizes_colors_products_id) OVER (PARTITION BY sizes_colors_products_id) as number_of_units')
         )
        ->where('client_id',$client->id)
        ->distinct()
        ->get();

       
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
