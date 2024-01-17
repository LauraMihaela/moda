<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use App\Models\SizeColorProduct;
use App\Models\Status;
use App\Models\Shipment;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;


class ShipmentController extends Controller
{
    
    public function index(){
        $shipments = Shipment::leftJoin('clients','shipments.client_id','clients.id')
        ->leftJoin('users','clients.user_id','users.id')
        ->leftJoin('sizes_colors_products','shipments.sizes_colors_products_id','sizes_colors_products.id')
        ->leftJoin('products','sizes_colors_products.product_id','products.id')
        ->leftJoin('status','shipments.status_id','status.id')
        ->select('users.username as username','products.product_name as product_name','status.status_name as status_name')
        ->get();

        // dd($shipments->toArray());
        return view('shipments.index')->with('shipments',$shipments);
    }

   
    public function create(){
    
        $allClients = Client::leftJoin('users','clients.user_id','users.id')
        ->select('clients.id as client_id','users.id as user_id','users.username as username','users.name as name','users.lastname as lastname','users.email as email')
        ->where('users.role_id','1')->distinct()->get();

        $allSizesColorsProducts = SizeColorProduct::leftJoin('products','sizes_colors_products.product_id','products.id')
        ->leftJoin('colors','sizes_colors_products.color_id','colors.id')
        ->leftJoin('sizes','sizes_colors_products.size_id','sizes.id')
        ->select('sizes_colors_products.id as id','products.product_name as product_name', 'colors.color_name as color_name', 'sizes.size_name as size_name')
        ->distinct()->get();

        $allStatus = Status::select('status.id as status_id','status.status_name as status_name')
        ->get();

        return view('shipments.create', compact('allClients','allSizesColorsProducts','allStatus'));
    }

    public function store(Request $request){
        // dd($request->all());
        $validatedData = $request->validate([
            'client_id' => 'required|integer',
            'sizes_colors_products_id' => 'required|integer',
            'status_id' => 'required|integer',
        ]);

        Shipment::create([
            'client_id' => $request->client_id,
            'sizes_colors_products_id' => $request->sizes_colors_products_id,
            'status_id' => $request->status_id,
        ]);
        
        return redirect()->to('/shipments')->with('message', 'El envío ha sido creado');
    }

    public function show(int $id){
        $shipment = Shipment::find($id);

        $shipmentUser = Shipment::leftJoin('clients','shipments.client_id','clients.id')
        ->leftJoin('users','clients.user_id','users.id')
        ->select('shipments.id as shipment_id','users.id as user_id','users.username as username','users.name as name','users.lastname as lastname','users.email as email')
        ->where('users.role_id','1')->where('shipments.id',$id)->first();

        // $shipmentUser = Arr::flatten($shipmentUser);

        // dd($shipmentUser->toArray());
        $sizes_colors_products = Shipment::leftJoin('sizes_colors_products','shipments.sizes_colors_products_id','sizes_colors_products.id')
        ->leftJoin('products','sizes_colors_products.product_id','products.id')
        ->leftJoin('colors','sizes_colors_products.color_id','colors.id')
        ->leftJoin('sizes','sizes_colors_products.size_id','sizes.id')
        ->select('products.product_name as product_name', 'colors.color_name as color_name', 'sizes.size_name as size_name')
        ->where('shipments.id',$id)->first();

        $status = Shipment::leftJoin('status','shipments.status_id','status.id')
        ->select('shipments.id as shipment_id','status.id as status_id','status.status_name as status_name')
        ->where('shipments.id',$id)->first();

        $status->status_name = changeShipmentStatus($status->status_name);

        return view('shipments.show', compact('shipment','shipmentUser','sizes_colors_products','status'));
    }

    public function edit(int $id){
        $shipment = Shipment::find($id);

        $shipmentUser = Shipment::leftJoin('clients','shipments.client_id','clients.id')
        ->leftJoin('users','clients.user_id','users.id')
        ->select('clients.id as client_id','users.id as user_id','users.username as username','users.name as name','users.lastname as lastname','users.email as email')
        ->where('users.role_id','1')->where('shipments.id',$id)->first();

        // dd($shipmentUser->toArray());

        $allClients = Client::leftJoin('users','clients.user_id','users.id')
        ->select('clients.id as client_id','users.id as user_id','users.username as username','users.name as name','users.lastname as lastname','users.email as email')
        ->where('users.role_id','1')->distinct()->get();


        // $allClients = User::select('users.id as user_id','users.username as username','users.name as name','users.lastname as lastname','users.email as email')
        // ->where('users.role_id','1')->distinct()->get();

        foreach ($allClients as $index=>$elem){
            if ($elem->user_id == $shipmentUser->user_id){
                $allClients->forget($index);
            }
        }

        // dd($allClients->toArray());
        
        $selectedSizesColorsProducts = Shipment::leftJoin('sizes_colors_products','shipments.sizes_colors_products_id','sizes_colors_products.id')
        ->leftJoin('products','sizes_colors_products.product_id','products.id')
        ->leftJoin('colors','sizes_colors_products.color_id','colors.id')
        ->leftJoin('sizes','sizes_colors_products.size_id','sizes.id')
        ->select('sizes_colors_products.id as id','products.product_name as product_name', 'colors.color_name as color_name', 'sizes.size_name as size_name')
        ->where('shipments.id',$id)->distinct()->first();

        $allSizesColorsProducts = SizeColorProduct::leftJoin('products','sizes_colors_products.product_id','products.id')
        ->leftJoin('colors','sizes_colors_products.color_id','colors.id')
        ->leftJoin('sizes','sizes_colors_products.size_id','sizes.id')
        ->select('sizes_colors_products.id as id','products.product_name as product_name', 'colors.color_name as color_name', 'sizes.size_name as size_name')
        ->distinct()->get();

        foreach ($allSizesColorsProducts as $index=>$elem){
            if ($elem->id == $selectedSizesColorsProducts->id){
                $allSizesColorsProducts->forget($index);
            }
        }

        $status = Shipment::leftJoin('status','shipments.status_id','status.id')
        ->select('status.id as status_id','status.status_name as status_name')
        ->where('shipments.id',$id)->first();
        $status->status_name = changeShipmentStatus($status->status_name);
        // dd(changeShipmentStatus($status->status_name));
        

        $allStatus = Status::select('status.id as status_id','status.status_name as status_name')
        ->get();

        // foreach ($allStatus as $index=>$elem){
        //     if ($elem->status_id == $status->status_id){
        //         $allStatus->forget($index);
        //     }
        // }
        // dd($allStatus->toArray());
        $allStatus->map(function ($elem, int $index) use($status,$allStatus){
            if ($elem->status_id == $status->status_id){
                $allStatus->forget($index);
            }
            $elem->status_name = changeShipmentStatus($elem->status_name);
            // dump($elem->toArray());
        });

        // dd($allStatus->toArray());

        return view('shipments.edit', compact('shipment','shipmentUser','allClients','selectedSizesColorsProducts','allSizesColorsProducts','status','allStatus'));

    }

    public function update(Request $request, int $id){
        // dd($request->all());
        $validatedData = $request->validate([
            'client_id' => 'integer',
            'sizes_colors_products_id' => 'required|integer',
            'status_id' => 'required|integer',
        ]);
        
        $shipment = Shipment::find($id);
        if(empty($shipment)){
            return redirect()->back()->withErrors("No se ha encontrado el envío");
        }
        if ($request->client_id){
            $shipment->client_id = $request->client_id;
        }
        $shipment->sizes_colors_products_id = $request->sizes_colors_products_id;
        $shipment->status_id = $request->status_id;
        $shipment->save();

        return redirect()->to('/shipments')->with('message', 'El envío ha sido actualizado');

    }

    public function destroy(int $id){
        $shipment = Shipment::find($id);
        if(empty($shipment)){
            return response()->json(['status' => 1, 'message' => "El envío no se ha encontrado"]);
        }
        $shipment->delete($id);
        return response()->json(['status' => 0, 'message' => "El envío ha sido eliminado"]);
    }

    public function datatable(Request $request){
        if(auth()->user()->role_id !== config('constants.roles.client_role')){
            $query = Shipment::leftJoin('clients','shipments.client_id','clients.id')
            ->leftJoin('users','clients.user_id','users.id')
            ->leftJoin('sizes_colors_products','shipments.sizes_colors_products_id','sizes_colors_products.id')
            ->leftJoin('products','sizes_colors_products.product_id','products.id')
            ->leftJoin('status','shipments.status_id','status.id')
            ->select('shipments.id as id','users.username as username','products.product_name as product_name','status.status_name as status_name')
            ->get();  
        }
        else{
            // El usuario logueado es un cliente
            $query = Shipment::leftJoin('clients','shipments.client_id','clients.id')
            ->leftJoin('users','clients.user_id','users.id')
            ->leftJoin('sizes_colors_products','shipments.sizes_colors_products_id','sizes_colors_products.id')
            ->leftJoin('products','sizes_colors_products.product_id','products.id')
            ->leftJoin('status','shipments.status_id','status.id')
            ->select('shipments.id as id','users.username as username','products.product_name as product_name','status.status_name as status_name')
            ->where('users.id',auth()->user()->id)
            ->get();  
        }
        $query->map(function ($elem, int $index){
            $elem->status_name = changeShipmentStatus($elem->status_name);
        });

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

        $shipments = Shipment::where('client_id',$clientId)->get();
        $numberOfShipments = 0;
        if ($shipments){
            $numberOfShipments = $shipments->count();
        }
        return response()->json(['status' => 0, 'message' => "Hay ".$numberOfShipments. " envíos.", 'numberOfShipments' => $numberOfShipments]);
    }
    
}
