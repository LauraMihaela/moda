<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Shipment;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;

class ShipmentController extends Controller
{
    
    public function index(){
        return view('shipments.index');
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
