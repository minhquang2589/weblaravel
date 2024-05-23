<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use Illuminate\Database\QueryException;
use App\Models\product_variants;
use App\Models\ProductVariant;
use App\Models\Size;
use App\Models\Color;
use App\Models\ProductCates;
use App\Models\ProductDetails;
use App\Models\Images;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class FilterController extends Controller
{
    //
    public function filterContent()
    {
        $newCount = Product::where('is_new', true)->count();
        $instockCount = ProductVariant::where('quantity', '>', 0)
            ->groupBy('product_id')
            ->select('product_id', DB::raw('sum(quantity) as total'))
            ->get()
            ->pluck('total', 'product_id')
            ->count();

        $outstockCounts = ProductVariant::select('product_id')
            ->where('quantity', '>=', 0)
            ->groupBy('product_id')
            ->havingRaw('SUM(quantity) = 0')
            ->pluck('product_id')
            ->count();

        $discountCount = DB::table('product_variants')
            ->join('discounts', 'product_variants.discount_id', '=', 'discounts.id')
            ->where('discounts.status', 'Active')
            ->groupBy('product_variants.product_id')
            ->select('product_variants.product_id', DB::raw('SUM(product_variants.quantity) as total_quantity'))
            ->pluck('total_quantity', 'product_variants.product_id')
            ->count();

        return response()->json([
            'success' => true,
            'newCount' => $newCount,
            'instockCount' => $instockCount,
            'outstockCount' => $outstockCounts,
            'discountCount' => $discountCount,
        ]);
    }
}
