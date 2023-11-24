<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    
    public function index(){
        return view('shipments.index');
    }
}
