<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Payment;
use App\Models\Customers;
use Illuminate\Support\Facades\Redirect;
use App\Models\color;
use App\Models\Product;
use App\Models\ordernumber;
use App\Models\size;
use App\Models\Discounts;
use App\Models\User;
use App\Models\product_colors;
use App\Models\product_sizes;
use Illuminate\Support\Str;
use App\Models\product_variants;
use App\Models\ProductVariant;
use App\Models\Vouchers;
use Illuminate\Support\Facades\Validator;
use App\Models\OrderItems;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;


class CheckoutController extends Controller
{
    // protected $emailController;

    // public function __construct(EmailController $emailController)
    // {
    //     $this->emailController = $emailController;
    // }

    //
    public function index(Request $request)
    {


        $cart = Session::get('cart');
        $orderNumber = Session::get('orderNumber');
        $dataCart = Session::get('dataCart');
        $aruvoucher = Session::get('aruvoucher');
        if ($cart) {
            $cartQuantity = count($cart);
        } else {
            $cartQuantity = 0;
        }
        $subtotal = 0;
        $totalWithoutVat = 0;
        $total = 0;
        $vatRate = 0;
        $vat = 0;
        $totalDiscountAmount = 0;
        $totalOriginalPrice = 0;

        if ($cart) {
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
                            $totalOriginalPrice += $productPrice * $item['quantity'];
                        } else {
                            return redirect()->route('error.page');
                        }
                    } else {
                        return redirect()->route('error.page');
                    }
                }
            }
        }
        $voucherCode = $request->input('voucher');
        if ($voucherCode) {
            $voucher = Vouchers::where('voucher_code', $voucherCode)
                ->where('voucher_quantity', '>', 0)
                ->where('status', '=', 'Active', '||', 'Used')
                ->where('discount_value', '>', 0)
                ->first();
            if ($voucher) {
                $VoucherValue = $voucher->discount_value;
                $voucherDiscountPercentage = ($VoucherValue / 100) * $subtotal;
                $subtotal -= $voucherDiscountPercentage;
                $totalDiscountAmount += $voucherDiscountPercentage;
            } else {
                return redirect()->back()->with(['error' => 'Voucher không hợp lệ hoặc đã hết hạn!']);
            }
        }

        $vat = $subtotal * $vatRate;
        $total = $totalWithoutVat + $vat;
        $DETACheckout = [
            'voucherCode' => $voucherCode ?? null,
            'checkoutTotal' => $total,
            'checkoutTotal' => $total,
            'checkoutSubtotal' => $subtotal,
            'VoucherValue' => $VoucherValue ?? null,
            'totalDiscountAmount' => $totalDiscountAmount ?? null,
            'cartCheckout' => $cart,
            'cartQuantity' => $cartQuantity,
        ];
        Session::put('DETACheckout', $DETACheckout);
        return view('layout.checkout', $DETACheckout);
    }

    /////
    public function process(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|regex:/^\d{10}$/',
            'address' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $customerExists = Customers::where('email', $request->input('email'))->exists();
        $userExists = User::where('email', $request->input('email'))->exists();

        function generateOrderNumber()
        {
            if (!Session::has('orderNumber')) {
                $randomDigits = Str::random(6);
                Session::put('orderNumber', $randomDigits);
                return  $randomDigits;
            } else {
                return Session::get('orderNumber');
            }
        }
        function getTime()
        {
            $currentDateTime = Carbon::now();
            $currentDateTime->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s');

            return $currentDateTime;
        }
        $time = getTime();
        $orderNumber = generateOrderNumber();
        $DETACheckout = Session::get('DETACheckout');
        $cart = Session::get('cart');
        $payment = $request->input('payment');
        switch ($payment) {
            case 'qr':
                $payment = 'Thanh toán bằng mã QR code';
                break;
            case 'meet':
                $payment = 'Thanh toán khi nhận hàng';
                break;
            case 'paypal':
                $payment = 'Thanh toán bằng Paypal';
                break;
            case 'bank':
                $payment = 'Chuyển khoản';
                break;
            default:
                break;
        }
        if (!$DETACheckout || !$cart) {
            return redirect()->route('error.page');
        }

        $element = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'notes' => $request->input('note'),
            'phone' => $request->input('phone'),
            'payment' =>  $payment,
            'subtotal' => $DETACheckout['checkoutSubtotal'],
            'total' => $DETACheckout['checkoutTotal'],
        ];
        $paymentName = $request->input('payment');
        if (!$paymentName) {
            return redirect()->back()->withErrors(['message' => 'Invalid payment method'])->withInput();
        }
        $dataCheckout = [
            'orderNumber' => $orderNumber,
            'time' => $time,
            'element' => $element,
            'cart' => $cart,
            'paymentName' => $paymentName,
            'totalDiscountAmount' => $DETACheckout['totalDiscountAmount'],
            'subtotal' => $DETACheckout['checkoutSubtotal'],
            'total' => $DETACheckout['checkoutTotal'],
        ];
        Session::put('element', $element);
        return view('payment.payment', $dataCheckout);
    }
    //////
    public function handlecheckout(Request $request)
    {
        // try {
        //     DB::beginTransaction();
            $time = $request->input('time');
            $total = $request->input('total');
            $cart = Session::get('cart');
            $orderNumber = Session::get('orderNumber');
            $data = Session::get('data');
            $element = Session::get('element');
            $DETACheckout = Session::get('DETACheckout');
            // dd($cart);

            if ($cart) {
                $voucherCode = $DETACheckout['voucherCode'];
                if ($voucherCode) {
                    $voucher = Vouchers::where('voucher_code', $voucherCode)->first();
                    if ($voucher) {
                        if (
                            $voucher->voucher_code != $voucherCode
                            || $voucher->discount_value <= 0
                            || $voucher->voucher_quantity <= 0
                            || $voucher->status != 'Active'
                        ) {
                            return redirect()->route('error.page');
                        }
                    }
                }
                foreach ($cart as $item) {
                    $productId = $item['id'];
                    $discountId = $item['discountId'];
                    $sizeName = $item['size'];
                    $colorName = $item['color'];
                    $quantity = $item['quantity'];
                    $productVariant = ProductVariant::whereHas('size', function ($query) use ($sizeName) {
                        $query->where('size', $sizeName);
                    })->whereHas('color', function ($query) use ($colorName) {
                        $query->where('color', $colorName);
                    })->where('product_id', $productId)->first();

                    if (!$productVariant || $productVariant->quantity < $quantity) {
                        return redirect()->route('error.page');
                    }
                    if ($discountId) {
                        $discount = Discounts::find($discountId);
                        $discountValue = $discount->discount;
                        if (
                            $discount->remaining < $quantity
                            || $discount->status == 'Used'
                            || $discount->status == 'Expired'
                            || $discount->discount <= 0
                        ) {
                            return redirect()->route('error.page');
                        }
                    }
                }
            } else {
                return redirect()->route('error.page');
            }
            // //// // //// // / update // // ////
            function checkoutSuccess()
            {
                $cart = Session::get('cart');
                $DETACheckout = Session::get('DETACheckout');
                $voucherCode = $DETACheckout['voucherCode'];
                if ($voucherCode) {
                    $voucher = Vouchers::where('voucher_code', $voucherCode)->first();
                    if ($voucher) {
                        $voucher->voucher_quantity -= 1;
                        if ($voucher->voucher_quantity <= 0) {
                            $voucher->status = 'Expired';
                        }
                        $voucher->save();
                    }
                }
                foreach ($cart as $item) {
                    $discountId = $item['discountId'];
                    $productId = $item['id'];
                    $sizeName = $item['size'];
                    $colorName = $item['color'];
                    $quantity = $item['quantity'];
                    $product = Product::find($productId);
                    if ($product) {
                        $newSalesCount = $product->sales_count + $quantity;
                        $product->sales_count = $newSalesCount;
                        $product->save();
                    }
                    $productVariant = ProductVariant::whereHas('size', function ($query) use ($sizeName) {
                        $query->where('size', $sizeName);
                    })->whereHas('color', function ($query) use ($colorName) {
                        $query->where('color', $colorName);
                    })->where('product_id', $productId)->first();

                    if ($productVariant) {
                        $newQuantity = max(0, $productVariant->quantity - $quantity);
                        $productVariant->update(['quantity' => $newQuantity]);
                    }

                    $discount  = Discounts::find($discountId);
                    if ($discount) {
                        $newQuantity = max(0, $discount->remaining - $quantity);
                        $discount->remaining = $newQuantity;
                        if ($discount->remaining <= 0) {
                            $discount->status = 'Expired';
                            $productVariantsToUpdate = ProductVariant::where('discount_id', $discountId)->get();
                            $productVariantsToUpdate->each(function ($productVariant) {
                                $productVariant->discount_id = null;
                                $productVariant->save();
                            });
                        }
                        $discount->save();
                    }
                }
            }
            // //// // //// // //// // //// // //// // //// // //// // //// // ////
            $email = $element['email'];
            $customer = Customers::where('email', $email)->first();
            if ($customer) {
                $customer->increment('total_purchases');
            } else {
                $data = [
                    'name' => $element['name'],
                    'email' => $element['email'],
                    'address' => $element['address'],
                    'phone' => $element['phone'],
                    'total_purchases' => 1,
                ];
                $customer = Customers::create($data);
            }
            $payment = Payment::firstOrCreate(['name' => $element['payment']]);
            $ordernumber = ordernumber::create([
                'order_number' => $orderNumber,
            ]);
            $status = 'Pedding';
            $paymentcheck = $element['payment'];
            switch ($paymentcheck) {
                case 'Thanh toán bằng mã QR code':
                    $status = 'Đang chờ xác nhận';
                    break;
                case 'Thanh toán khi nhận hàng':
                    $status = 'Chưa thanh toán';
                    break;
                case 'Thanh toán bằng Paypal':
                    $status = 'Thanh toán bằng Paypal';
                    break;
                case 'Chuyển khoản':
                    $status = 'Đang chờ xác nhận';
                    break;
                default:
                    break;
            }

            $order = new Orders();
            $order->customer_id = $customer->id;
            $order->total_amount = $element['subtotal'] ?? $total;
            $order->total_discount = $DETACheckout['totalDiscountAmount'] ?? 0;
            $order->payment_method_id = $payment->id;
            $order->status = $status;
            if (isset($element['notes']) && !empty($element['notes'])) {
                $data['notes'] = $element['notes'];
                $order->notes = $data['notes'];
            }
            $voucherCode = $DETACheckout['voucherCode'];
            if ($voucherCode) {
                $voucher = Vouchers::where('voucher_code', $voucherCode)->first();
                if ($voucher) {
                    $order->voucher_id =  $voucher->id;
                }
            } else {
                $order->voucher_id = null;
            }
            $order->order_number_id = $ordernumber->id;
            $order->order_date = $time;
            $order->save();
            // dd($cart);

            foreach ($cart as &$item) {
                if (isset($item['price']) && isset($item['discountPercent'])) {
                    $price = $item['price'];
                    $discountPercent = $item['discountPercent'];
                    $discountAmount = ($price * $discountPercent) / 100;
                    $finalPrice = $price - $discountAmount;
                    $item['finalPrice'] = $finalPrice;
                } else {
                    $item['finalPrice'] = $item['price'];
                }

                $productId = $item['id'];
                $colorName = $item['color'];
                $sizeName = $item['size'];
                $colorId = Color::where('color', $colorName)->value('id');
                $sizeId = Size::where('size', $sizeName)->value('id');

                if ($productId && $colorId && $sizeId) {
                    $orderItem = new OrderItems();
                    $orderItem->order_id = $order->id;
                    $orderItem->product_id = $productId;
                    $orderItem->color_id = $colorId;
                    $orderItem->size_id = $sizeId;
                    $orderItem->order_number_id = $ordernumber->id;
                    $orderItem->quantity = $item['quantity'];
                    $orderItem->price = $item['price'];
                    $orderItem->save();
                }
            }
            checkoutSuccess();
            $orderDate =  $time;
            $emailController = new EmailController();
            $emailController->sendMail(
                $orderDate,
                $element,
                $orderNumber,
                $cart,
                $DETACheckout
            );
            Session::forget('cart');
            Session::forget('data');
            Session::forget('subtotal');
            Session::forget('voucherCode');
            Session::forget('aruvoucher');
            Session::forget('DETACheckout');
            Session::forget('element');
            Session::forget('dataCart');
            Session::forget('total');
            Session::forget('voucherDiscountPercent');
            Session::forget('cartQuantity');
            Session::forget('orderNumber');
            DB::commit();
            return view('layout.confirm');
       
    }
}
