<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\size;
use App\Models\color;
use App\Models\ProductCates;
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
        function getProductVariants()
        {
            $productVariants = product_variants::with('size', 'color')->get();
            return $productVariants;
        }
        $stock = getProductVariants();
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
        return view('crud.updateproduct', [
            'discountInfo' => $discountInfo,
            'product' => $product,
            'productImages' => $productImages,
            'stock' => $stock,
            'sizes' => $sizes,
            'colors' => $colors,
            'quantities' => $quantities,
            'productCate' => $productCate
        ]);
    }
    //////////////////////////// update ////////////////////////////////////////////
    public function update(Request $request)
    {

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

        $productCate = ProductCates::where('id', $product->cate_id)->first();
        $productCate->gender = $request->input('gender');
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

        if ($request->has('colors') && $request->has('quantities')) {
            $colors = $request->colors;
            $quantities = $request->quantities;
            foreach ($colors as $key => $color) {
                $sizes = $quantities[$key];
                $colorModel = Color::updateOrCreate(['color' => $color]);
                foreach ($sizes as $size => $quantity) {
                    if (!empty($quantity)) {
                        $sizeModel = Size::updateOrCreate(['size' => $size]);
                        $productVariant = ProductVariant::updateOrCreate(
                            [
                                'product_id' => $product->id,
                                'size_id' => $sizeModel->id,
                                'color_id' => $colorModel->id,
                            ],
                            ['quantity' => $quantity]
                        );
                    }
                }
            }
        }

        $discount = Discounts::whereHas('productVariants', function ($query) use ($product) {
            $query->where('product_id', $product->id);
        })->orderBy('created_at', 'desc')->first();

        foreach ($request->except('_token', 'product_name', 'price', 'description', 'images', 'is_new') as $colorName => $sizes) {
            if (is_array($sizes) && array_filter($sizes)) {
                $colorModel = Color::firstOrCreate(['color' => $colorName]);
                foreach ($sizes as $size => $quantity) {
                    if (!empty($quantity)) {
                        $sizeModel = Size::firstOrCreate(['size' => $size]);
                        $productVariant = ProductVariant::updateOrCreate(
                            [
                                'product_id' => $product->id,
                                'size_id' => $sizeModel->id,
                                'color_id' => $colorModel->id,
                            ],
                            [
                                'quantity' => $quantity,
                                'discount_id' => $discount ? $discount->id : null,
                            ]
                        );
                    }
                }
            }
        }
        return redirect()->back()->with('success', 'Product updated successfully!');
    }
    ////////////////////////////////////////////////////////////////////////



}
