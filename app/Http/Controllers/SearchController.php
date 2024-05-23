<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;


class SearchController extends Controller
{
    //
    public function search(Request $request)
    {
        $search = $request->input('search');
        $product_search = Product::where('name', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%')
            ->get();
        $product_search_count = Product::where('name', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%')
            ->count();
        return view('layout.product_search_view', [
            'product_search' => $product_search,
            'product_search_count' => $product_search_count,
            'searchkey' => $search
        ]);
    }
}
