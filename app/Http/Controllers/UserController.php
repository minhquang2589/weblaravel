<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\image;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\product_variants;
use App\Models\ProductVariant;
use App\Models\featured_sections;
use App\Models\Size;
use App\Models\About;
use App\Models\Blog;
use App\Models\Color;
use Illuminate\Support\Facades\View;
use App\Models\Users;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    //
    public function about()
    {
        return view('about.about');
    }
    //
    public function product()
    {
       
        //
        $discountProduct = Product::select(
            'products.id',
            'products.name',
            'products.description',
            'products.price',
            'products.is_new',
            'discounts.quantity as discount_quantity',
            'discounts.discount',
            'discounts.status',
            DB::raw('(SELECT image FROM images WHERE product_id = products.id ORDER BY id LIMIT 1) as image')
        )
            ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->leftJoin('discounts', 'product_variants.discount_id', '=', 'discounts.id')
            ->where('discounts.quantity', '>', 0)
            ->where('discounts.status', 'Active')
            ->groupBy(
                'products.id',
                'products.name',
                'products.description',
                'products.price',
                'products.is_new',
                'discounts.quantity',
                'discounts.discount',
                'discounts.status'
            )
            ->orderByDesc('products.sales_count')
            ->take(8)
            ->get();

      
        $dataProduct = [
            'discountProduct' => $discountProduct,
        ];
        return view('auth.product',  $dataProduct);
    }
    ////
    public function getProduct(Request $request)
    {

        $page = $request->input('page');
        $new = $request->input('new');
        $sale = $request->input('sale');
        $instock = $request->input('instock');
        $outofstock = $request->input('outofstock');
        $priceFrom = $request->input('priceFrom');
        $priceTo = $request->input('priceTo');
        $search = $request->input('search');
        $perPage = 36;

        $query = Product::select(
            'products.id',
            'products.name',
            'products.description',
            'products.price',
            'products.is_new',
            DB::raw('SUM(product_variants.quantity) as total_quantity'),
            'discounts.quantity as discount_quantity',
            'discounts.discount',
            'discounts.status',
            DB::raw('(SELECT image FROM images WHERE product_id = products.id ORDER BY id LIMIT 1) as image')
        )
            ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->leftJoin('discounts', 'product_variants.discount_id', '=', 'discounts.id')
            ->groupBy(
                'products.id',
                'products.name',
                'products.description',
                'products.price',
                'products.is_new',
                'discounts.quantity',
                'discounts.discount',
                'discounts.status'
            );

        if ($sale === "true") {
            $query->where('discounts.status', 'Active')
                ->where('discounts.discount', '>', 0)
                ->where('discounts.quantity', '>', 0);
        }
        if ($new === "true") {
            $query->where('products.is_new', '=', 1);
        }
        if ($instock === "true") {
            $query->havingRaw('total_quantity > 0');
        }
        if ($outofstock === "true") {
            $query->havingRaw('total_quantity = 0');
        }
        if (is_numeric($priceFrom)) {
            $query->where('products.price', '>=', $priceFrom);
        }
        if (is_numeric($priceTo)) {
            $query->where('products.price', '<=', $priceTo);
        }
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('products.name', 'LIKE', '%' . $search . '%')
                    ->orWhere('products.description', 'LIKE', '%' . $search . '%');
            });
        }
        $products = $query->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();
        $hasMore = $products->count() >= $perPage;
        return response()->json([
            'success' => true,
            'products' => $products,
            'hasMore' => $hasMore,
            'page' => $page,
        ]);
    }

    //////

    public function blog()
    {
        return view('blog.blog');
    }
    public function contact()
    {
        return view('layout.contact');
    }
    public function profile()
    {
        // $ProfileUser = Users::
        if (Auth::check()) {
            $ProfileUser = Auth::user();
            $ProfileUser = [
                'name' => $ProfileUser->name,
                'email' => $ProfileUser->email,
                'phone' => $ProfileUser->phone,
                'birthday' => $ProfileUser->birthday,
                'genders' => $ProfileUser->genders,
                'address' => $ProfileUser->address,
            ];
        }
        // dd($ProfileUser);
        return view('auth.profile', ['ProfileUser' => $ProfileUser]);
    }
}
