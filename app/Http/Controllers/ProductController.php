<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\product_variants;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Session;
use App\Models\Size;
use App\Models\Color;
use App\Models\ProductCates;
use App\Models\ProductDetails;
use App\Models\Images;
use Illuminate\Database\QueryException;



class ProductController extends Controller
{
   //
   public function view($id)
   {
      $product = Product::select(
         'products.id',
         'products.name',
         'products.description',
         'products.price',
         'products.is_new',
         DB::raw('SUM(product_variants.quantity) as total_quantity'),
         'discounts.quantity as discount_quantity',
         'discounts.discount',
         'discounts.remaining',
         'discounts.id as discount_id',
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
            'discounts.remaining',
            'discounts.discount',
            'discounts.id',
         )
         ->find($id);
      if (!$product) {
         abort(404, 'Product not found');
      }
      $productVariants = product_variants::where('product_id', $id)->get();
      $ProductDetailImg = Images::where('product_id', $id)->get();
      $sizeIds = $productVariants->pluck('size_id')->unique()->filter();
      $colorIds = $productVariants->pluck('color_id')->unique()->filter();
      $sizes = Size::whereIn('id', $sizeIds)->get();
      $colors = Color::whereIn('id', $colorIds)->get();
      $productkankei = Product::inRandomOrder()->take(10)->select(
         'products.id',
         'products.name',
         'products.description',
         'products.price',
         'products.is_new',
         DB::raw('SUM(product_variants.quantity) as total_quantity'),
         'discounts.quantity as discount_quantity',
         'discounts.discount',
         'discounts.id',
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
            'discounts.id'
         )
         ->get();

      $product_info = DB::table('products')
         ->join('product_cates', 'products.cate_id', '=', 'product_cates.id')
         ->join('product_details', 'products.detail_id', '=', 'product_details.id')
         ->select(
            'products.*',
            'product_cates.gender as category_name',
            'product_cates.gender as category_genter',
            'product_details.description1 as product_description1',
            'product_details.description2 as product_description2',
            'product_details.description3 as product_description3',
            'product_details.description4 as product_description4',
            'product_details.description5 as product_description5',
            'product_details.description6 as product_description6',
         )
         ->where('products.id', '=', $id)
         ->first();


      return view('auth.viewproduct', [
         'product_info' => $product_info,
         'ProductDetailImg' => $ProductDetailImg,
         'product' => $product,
         'sizes' => $sizes,
         'colors' => $colors,
         'productkankei' => $productkankei,

      ]);
   }
   ////
   public function loadMoreProduct(Request $request)
   {
      $page = $request->input('page');
      $perPage = 30;
      $productsMore = Product::orderBy('sales_count', 'desc')
         ->skip(($page - 1) * $perPage)
         ->take($perPage)
         ->select(
            'products.id',
            'products.name',
            'products.description',
            'products.price',
            'products.is_new',
            DB::raw('SUM(product_variants.quantity) as total_quantity'),
            'discounts.quantity as discount_quantity',
            'discounts.discount',
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
            'discounts.discount'
         )
         ->get();
      $hasMore = $productsMore->count() == $perPage;
      return response()->json([
         'productsMore' => $productsMore,
         'hasMore' => $hasMore
      ]);
   }

   ///
   public function newproduct()
   {
      return view('auth.newproduct');
   }
   //
   public function getNewproduct(Request $request)
   {
      $page = $request->input('page');
      $perPage = 36;
      $newproducts = Product::select(
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
         ->where('is_new', 1)
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
         ->skip(($page - 1) * $perPage)
         ->take($perPage)
         ->get();
      return response()->json([
         'success' => true,
         'newproducts' => $newproducts,
         'page' => $page,
      ]);
   }
   // //////////////////////////////////////////////////////////////////////////
   public function checkStock(Request $request)
   {
      $productId = $request->input('product_id');
      $sizeName = $request->input('size');
      $colorName = $request->input('color');

      $size = Size::where('size', $sizeName)->first();
      $color = Color::where('color', $colorName)->first();

      if (!$size || !$color) {
         return response()->json(['status' => 'error', 'message' => 'Size or color not found']);
      }

      $product = Product::find($productId);
      $productVariant = ProductVariant::where('product_id', $product->id)
         ->whereHas('size', function ($query) use ($size) {
            $query->where('size', $size->size);
         })
         ->whereHas('color', function ($query) use ($color) {
            $query->where('color', $color->color);
         })
         ->first();

      if (!$productVariant) {
         return response()->json([
            'status' => 'out_of_stock',
         ]);
      }
      $data = [
         'size' => $sizeName,
         'color' => $colorName,
         'productVariant' => $productVariant,
      ];

      if ($productVariant->quantity > 0) {
         return response()->json([
            'status' => 'available',
            'data' => $data,
         ]);
      } else {
         return response()->json([
            'status' => 'out_of_stock',
            'data' => $data,
         ]);
      }
   }




   //
   public function checkQuantityProduct(Request $request)
   {
      $productId = $request->input('product_id');
      $productVariants = product_variants::where('product_id', $productId)->get();

      $totalQuantity = $productVariants->sum('quantity');
      $data = [
         'totalQuantity' => $totalQuantity
      ];

      return response()->json($data);
   }

   ///
   public function removeproduct($id)
   {
      try {
         DB::beginTransaction();
         $product = Product::find($id);
         if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
         }
         $product->delete();
         DB::commit();
         return redirect()->back()->with('success', 'Product deleted successfully.');
      } catch (\Exception $e) {
         DB::rollBack();
         return redirect()->back()->with('error', 'Failed to delete product.');
      }
   }




   //

}
