<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function cartIndex(){
        return view('cart.index');
    }
}
