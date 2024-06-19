<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\size;
use App\Models\color;
use App\Models\ProductCates;
use App\Models\ProductDetails;
use App\Models\Discounts;
use App\Models\Images;
use App\Models\product_variants;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use Symfony\Component\VarDumper\VarDumper;

class CRUDController extends Controller
{
    //
    public function edit($id)
    {
        $product = Product::find($id);
        $productVariants = ProductVariant::where('product_id', $id)->get();
        $productImages = Images::where('product_id', $id)->get();
        $sizes = [];
        $colors = [];
        $quantities = [];
        foreach ($productVariants as $variant) {
            $size = Size::find($variant->size_id);
            $color = Color::find($variant->color_id);
            $sizes[] = $size ? $size->size : '';
            $colors[] = $color ? $color->color : '';
            $quantities[] = $variant->quantity;
        }
        $stock = product_variants::with('size', 'color')
            ->where('product_id', $product->id)
            ->get();

        foreach ($stock as $productVariant) {
            $size = $productVariant->size;
            $color = $productVariant->color;
            $quantity = $productVariant->quantity;
        }

        $discountInfo = Discounts::select(
            'discounts.start_datetime',
            'discounts.end_datetime',
            'discounts.discount',
            DB::raw('discounts.quantity as total_quantity')
        )
            ->join('product_variants', function ($join) use ($id) {
                $join->on('discounts.id', '=', 'product_variants.discount_id')
                    ->where('product_variants.product_id', '=', $id);
            })
            ->where('product_variants.quantity', '>=', 0)
            ->first();

        $productCate = ProductCates::where('id', $product->cate_id)->first();
        $ProductDetails = ProductDetails::where('product_id', $product->id)->get();
        // dd($sizes, $colors);
        return view('crud.updateproduct', [
            'discountInfo' => $discountInfo,
            'product' => $product,
            'productImages' => $productImages,
            'stock' => $stock,
            'sizes' => $sizes,
            'colors' => $colors,
            'quantities' => $quantities,
            'productCate' => $productCate,
            'ProductDetails' => $ProductDetails
        ]);
    }
    //////////////////////////// update ////////////////////////////////////////////
    public function update(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string',
            'price' => 'required',
            'gender' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $product = Product::findOrFail($request->product_id);
        $product->name = $request->input('product_name');
        $product->price = $request->input('price');
        $product->description = $request->input('description');
        $product->is_new = $request->has('is_new') ? 1 : 0;
        $product->save();

        $ProductDetails = ProductDetails::where('product_id', $product->id);
        if ($ProductDetails->exists() && $request->details != null) {
            $ProductDetails->delete();
            foreach ($request->details as $detail) {
                $productDetails = new ProductDetails();
                $productDetails->product_id = $product->id;
                $productDetails->description = $detail;
                $productDetails->save();
            }
        }

        $productCate = ProductCates::where('id', $product->cate_id)->first();
        $productCate->gender = $request->input('gender');
        $productCate->description = "For " . $request->input('gender');
        $productCate->save();

        if ($request->hasFile('images')) {
            Images::where('product_id', $product->id)->delete();
            foreach ($request->file('images') as $image) {
                $originName = $image->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $fileName = $fileName . '_' . time() . '.' . $extension;
                $image->move(public_path('images'), $fileName);
                $url = asset('images/' . $fileName);
                Images::create([
                    'product_id' => $product->id,
                    'image' => $fileName
                ]);
            }
        }

        $discount = Discounts::whereHas('productVariants', function ($query) use ($product) {
            $query->where('product_id', $product->id);
        })->orderBy('created_at', 'desc')->first();
        // dd($request->all());

        if ($request->has('colors')) {
            $colors = $request->colors;
            foreach ($colors as $colorName => $sizeData) {
                $colorModel = Color::updateOrCreate(['color' => $colorName]);
                $totalQuantity = 0;
                foreach ($sizeData as $sizeName => $quantity) {
                    if ($quantity !== null) {
                        $totalQuantity += $quantity;
                        $sizeModel = Size::updateOrCreate(['size' => $sizeName]);
                        $productVariant = ProductVariant::where([
                            'product_id' => $product->id,
                            'size_id' => $sizeModel->id,
                            'color_id' => $colorModel->id,
                        ])->first();
                        if ($productVariant) {
                            $productVariant->quantity = $quantity;
                            $productVariant->save();
                        } else {
                            $productVariant = ProductVariant::create([
                                'product_id' => $product->id,
                                'size_id' => $sizeModel->id,
                                'color_id' => $colorModel->id,
                                'discount_id' => $discount ? $discount->id : null,
                                'quantity' => $quantity,
                            ]);
                        }
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'Product updated successfully!');
    }
    ////////////////////////////////////////////////////////////////////////



}
