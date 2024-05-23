<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use App\Models\Vouchers;
use App\Models\ProductVariant;
use App\Models\Discounts;
use App\Models\Images;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\product_variants;
use Illuminate\Support\Facades\Session;


class CartController extends Controller
{

    public function index()
    {
        // Session::flush(); 
        $viewcartData = Session::get('cart');
        // dd($viewcartData);
        return view('layout.cart', ['viewcartData' => $viewcartData]);
    }
    //
    public function addcart(Request $request)
    {
        ////
        $productId = $request->input('product_id');
        $discountId = $request->input('discount_id');
        $product = Product::find($productId);
        $img = Images::where('product_id', $productId)->first();
        if ($img) {
            $imageUrl = $img->image;
        } else {
            $imageUrl = null;
        }
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }
        $size = $request->input('size');
        $color = $request->input('color');
        $discountPercent = $request->input('discountPercent');

        if ($size == 'selectsize' || $color == 'selectcolor') {
            return redirect()->back()->with(['error' => 'Please select size and color.']);
        }
        if (session()->has('cart')) {
            $cart = session()->get('cart');
        } else {
            $cart = [];
        }
        $productVariant = ProductVariant::where('product_id', $product->id)
            ->whereHas('size', function ($query) use ($size) {
                $query->where('size', $size);
            })
            ->whereHas('color', function ($query) use ($color) {
                $query->where('color', $color);
            })
            ->first();
        if (!$productVariant || $productVariant->quantity <= 0) {
            return response()->json([
                'success' => false,
                'error' => 'This product is out of stock.'
            ]);
        }
        $totalQuantityInCart = 0;
        foreach ($cart as $item) {
            if ($item['id'] == $productId && $item['size'] == $size && $item['color'] == $color) {
                $totalQuantityInCart += $item['quantity'];
            }
        }

        $totalQuantityAvailable = $productVariant->quantity;
        $requestedQuantity = $totalQuantityInCart + 1;
        if ($requestedQuantity > $totalQuantityAvailable) {
            return response()->json([
                'success' => false,
                'error' => 'The quantity exceeds the remaining stock.'
            ]);
        }

        $existingCartItem = null;
        foreach ($cart as $key => $item) {
            if ($item['id'] == $productId && $item['size'] == $size && $item['color'] == $color) {
                $existingCartItem = $key;
                break;
            }
        }

        if ($existingCartItem !== null) {
            $cart[$existingCartItem]['quantity']++;
        } else {
            $cart[] = [
                'id' => $productId,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $imageUrl,
                'quantity' => 1,
                'discountPercent' => $discountPercent,
                'discountId' => $discountId,
                'size' => $size,
                'color' => $color,
            ];
        }

        $subtotal = 0;
        $totalWithoutVat = 0;
        $total = 0;
        $vatRate = 0;

        foreach ($cart as $item) {
            if (is_array($item) && isset($item['id'])) {
                $discount = $item['discountPercent'] ?? 0;
                $product = Product::find($item['id']);
                if ($product) {
                    $productPrice = $product->price;
                    $productVariant = ProductVariant::where('product_id', $product->id)
                        ->whereHas('size', function ($query) use ($item) {
                            $query->where('size', $item['size']);
                        })
                        ->whereHas('color', function ($query) use ($item) {
                            $query->where('color', $item['color']);
                        })
                        ->first();
                    if ($productVariant) {
                        if ($productVariant->discount_id) {
                            $discountData = Discounts::where('id', $productVariant->discount_id)
                                ->where('start_datetime', '<=', Carbon::now())
                                ->where('end_datetime', '>=', Carbon::now())
                                ->first();
                            if ($discountData) {
                                $discount = $discountData->discount;
                            }
                        }
                        $discountAmount = ($productPrice * $discount) / 100;
                        $subtotal += ($productPrice - $discountAmount) * $item['quantity'];
                        $totalWithoutVat += $productPrice * $item['quantity'];
                    } else {
                        return redirect()->route('error.page');
                    }
                } else {
                    return redirect()->route('error.page');
                }
            }
        }

        $vat = $subtotal * $vatRate;
        $total = $totalWithoutVat + $vat;
        $cartQuantity = count($cart);
        $dataCart = [
            'total' => $total,
            'subtotal' => $subtotal,
            'vat' => $vat,
            'cartQuantity' => $cartQuantity,
        ];

        session()->put('cart', $cart);
        session()->put('dataCart', $dataCart);
        return response()->json([
            'success' => 'cart successfully.',
            'cart' =>  $cart,
        ]);
    }
    /////////////////////////////////////////////

    public function cartremore(Request $request)
    {
        $productId = $request->input('product_id');
        $size = $request->input('size');
        $color = $request->input('color');
        $cart = session()->get('cart', []);
        $dataCart = Session::get('dataCart');
        foreach ($cart as $key => $item) {
            if ($item['id'] == $productId) {
                if ((!$size || (isset($item['size']) && $item['size'] == $size)) && (!$color || $item['color'] == $color)) {
                    if (!$request->has('quantity') || ($request->input('quantity') == $item['quantity'])) {
                        unset($cart[$key]);
                        session()->put('cart', $cart);
                        $subtotal = 0;
                        $totalWithoutVat = 0;
                        $total = 0;
                        $vatRate = 0;
                        $vat = 0;
                        foreach ($cart as $item) {
                            if (is_array($item) && isset($item['id'])) {
                                $discount = $item['discountPercent'] ?? 0;
                                $product = Product::find($item['id']);
                                if ($product) {
                                    $productPrice = $product->price;
                                    $productVariant = ProductVariant::where('product_id', $product->id)
                                        ->whereHas('size', function ($query) use ($item) {
                                            $query->where('size', $item['size']);
                                        })
                                        ->whereHas('color', function ($query) use ($item) {
                                            $query->where('color', $item['color']);
                                        })
                                        ->first();
                                    if ($productVariant) {
                                        if ($productVariant->discount_id) {
                                            $discountData = Discounts::where('id', $productVariant->discount_id)
                                                ->where('start_datetime', '<=', Carbon::now())
                                                ->where('end_datetime', '>=', Carbon::now())
                                                ->first();
                                            if ($discountData) {
                                                $discount = $discountData->discount;
                                            }
                                        }
                                        $discountAmount = ($productPrice * $discount) / 100;
                                        $subtotal += ($productPrice - $discountAmount) * $item['quantity'];
                                        $totalWithoutVat += $productPrice * $item['quantity'];
                                    } else {
                                        return redirect()->route('error.page');
                                    }
                                } else {
                                    return redirect()->route('error.page');
                                }
                            }
                        }

                        $vat = $subtotal * $vatRate;
                        $total = $totalWithoutVat + $vat;
                        $cartQuantity = count($cart);

                        $dataCart = [
                            'total' => $total,
                            'subtotal' => $subtotal,
                            'vat' => $vat,
                            'cartQuantity' => $cartQuantity,
                        ];
                        Session::put('dataCart', $dataCart);
                        Session::put('cart', $cart);
                        return response()->json(['success' => 'Product removed from cart successfully.', 'cart' => $cart]);
                    } else {
                        return response()->json(['error' => 'Quantity mismatch.'], 400);
                    }
                }
            }
        }
        return response()->json(['error' => 'Product not found in cart.'], 404);
    }
    ////////////////////////////////////////////////////////////////
    public function cartviewremore(Request $request)
    {
        $productId = $request->input('product_id');
        $size = $request->input('size');
        $color = $request->input('color');
        $cart = session()->get('cart', []);
        foreach ($cart as $key => $item) {
            if ($item['id'] == $productId) {
                if ((!$size || (isset($item['size']) && $item['size'] == $size)) && (!$color || $item['color'] == $color)) {
                    if (!$request->has('quantity') || ($request->input('quantity') == $item['quantity'])) {
                        unset($cart[$key]);
                        session()->put('cart', $cart);
                        $subtotal = 0;
                        $totalWithoutVat = 0;
                        $total = 0;
                        $vat = 0;
                        $vatRate = 0;

                        foreach ($cart as $item) {
                            if (is_array($item) && isset($item['id'])) {
                                $discount = $item['discountPercent'] ?? 0;
                                $product = Product::find($item['id']);
                                if ($product) {
                                    $productPrice = $product->price;
                                    $productVariant = ProductVariant::where('product_id', $product->id)
                                        ->whereHas('size', function ($query) use ($item) {
                                            $query->where('size', $item['size']);
                                        })
                                        ->whereHas('color', function ($query) use ($item) {
                                            $query->where('color', $item['color']);
                                        })
                                        ->first();
                                    if ($productVariant) {
                                        if ($productVariant->discount_id) {
                                            $discountData = Discounts::where('id', $productVariant->discount_id)
                                                ->where('start_datetime', '<=', Carbon::now())
                                                ->where('end_datetime', '>=', Carbon::now())
                                                ->first();
                                            if ($discountData) {
                                                $discount = $discountData->discount;
                                            }
                                        }
                                        $discountAmount = ($productPrice * $discount) / 100;
                                        $subtotal += ($productPrice - $discountAmount) * $item['quantity'];
                                        $totalWithoutVat += $productPrice * $item['quantity'];
                                    } else {
                                        return redirect()->route('error.page');
                                    }
                                } else {
                                    return redirect()->route('error.page');
                                }
                            }
                        }

                        $vat = $subtotal * $vatRate;
                        $total = $totalWithoutVat + $vat;
                        $cartQuantity = count($cart);
                        $dataCart = [
                            'total' => $total,
                            'subtotal' => $subtotal,
                            'vat' => $vat,
                            'cartQuantity' => $cartQuantity,
                        ];
                        Session::put('dataCart', $dataCart);
                        Session::put('cart', $cart);
                        return response()->json(['success' => 'Product removed from view cart successfully.', 'cart' => $cart]);
                    } else {
                        return response()->json(['error' => 'removed from view cart fail.']);
                    }
                }
            }
        }
        return redirect()->back()->with('error', 'Product not found in cart.');
    }


    // ///////////////////////////// product_variants  /////////////////////////////////////////////
    public function updateQuantity(Request $request)
    {
        $productId = $request->input('product_id');
        $newQuantity = $request->input('quantity');
        $color = $request->input('color');
        $size = $request->input('size');

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return response()->json(['success' => false, 'message' => 'Cart is empty.']);
        }
        $productVariant = product_variants::where('product_id', $productId)
            ->whereHas('size', function ($query) use ($size) {
                $query->where('size', $size);
            })
            ->whereHas('color', function ($query) use ($color) {
                $query->where('color', $color);
            })
            ->first();
        if (!$productVariant) {
            return redirect()->route('error.page')->withInput();
        }
        $availableQuantity = $productVariant->quantity;
        if ($newQuantity > $availableQuantity) {
            return response()->json(['success' => false, 'message' => 'The quantity exceeds the remaining stock.']);
        }
        foreach ($cart as $key => $item) {
            if ($item['id'] == $productId && $item['color'] == $color && $item['size'] == $size) {

                if (!$productVariant) {
                    return redirect()->route('error.page')->withInput();
                }
                $availableQuantity = $productVariant->quantity;
                if ($newQuantity > $availableQuantity) {
                    return redirect()->back()->with('success', 'Quantity updated successfully.');
                }
                $cart[$key]['quantity'] = $newQuantity;
                session()->put('cart', $cart);
                Session::put('cart', $cart);
                return response()->json(['success' => true]);
            }
        }
        return response()->json(['success' => false, 'message' => 'Product not found in cart.']);
    }

    /////////////////////
    public function getCartQuantity()
    {
        $cartQuantity = count(session('cart', []));
        return response()->json(['cartQuantity' => $cartQuantity]);
    }
    ///


    public function updateTime(Request $request)
    {
        $cart = Session::get('cart');
        $total = Session::get('total');
        $subtotal = Session::get('subtotal');

        $dataview = [
            'cart' => $cart,
            'subtotal' => $subtotal,
            'total' => $total,
        ];

        return response()->json($dataview);
    }
    ///
    public function SubtotalTotal(Request $request)
    {
        $cart = Session::get('cart');

        $subtotal = 0;
        $totalWithoutVat = 0;
        $total = 0;
        $vatRate = 0;
        $totalDiscountAmount = 0;
        $totalOriginalPrice = 0;
        $cartQuantity = 0;
        if (isset($cart) && count($cart) > 0) {
            $cartQuantity = count($cart);
            foreach ($cart as $item) {
                if (is_array($item) && isset($item['id'])) {
                    $discount = $item['discountPercent'] ?? 0;
                    $product = Product::find($item['id']);
                    if ($product) {
                        $productPrice = $product->price;
                        $productVariant = ProductVariant::where('product_id', $product->id)
                            ->whereHas('size', function ($query) use ($item) {
                                $query->where('size', $item['size']);
                            })
                            ->whereHas('color', function ($query) use ($item) {
                                $query->where('color', $item['color']);
                            })
                            ->first();
                        if ($productVariant) {
                            if ($productVariant->discount_id) {
                                $discountData = Discounts::where('id', $productVariant->discount_id)
                                    ->where('start_datetime', '<=', Carbon::now())
                                    ->where('end_datetime', '>=', Carbon::now())
                                    ->first();
                                if ($discountData) {
                                    $discount = $discountData->discount;
                                }
                            }
                            $discountAmount = ($productPrice * $discount) / 100;
                            $subtotal += ($productPrice - $discountAmount) * $item['quantity'];
                            $totalWithoutVat += $productPrice * $item['quantity'];
                            $totalDiscountAmount += $discountAmount * $item['quantity'];
                        } else {
                            return redirect()->route('error.page');
                        }
                    } else {
                        return redirect()->route('error.page');
                    }
                }
            }
        }

        $vat = $subtotal * $vatRate;
        $total = $totalWithoutVat + $vat;

        $dataSubtotalTotal = [
            'total' => $total,
            'subtotal' => $subtotal,
            'cartQuantity' => $cartQuantity,
            'totalDiscountAmount' => $totalDiscountAmount,
        ];
        return response()->json(['dataSubtotalTotal' => $dataSubtotalTotal]);
    }
}
