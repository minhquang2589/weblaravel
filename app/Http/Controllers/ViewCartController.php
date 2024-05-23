<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Product;




class ViewCartController extends Controller
{
    //
    public function viewCart()
    {
        $cart = Session::get('cart');
        return response()->json(['cart' => $cart]);
    }

    public function show($id)
    {
        // dd($id);
        $cart = Session::get('cart');
        return response()->json(['cart' => $cart]);
    }


    // public function index()
    // {
    //     $products = Product::with('variants.color', 'variants.size', 'variants.image')->get();
    //     return view('dataview.productkankei', ['products' => $products]);
    // }
}
