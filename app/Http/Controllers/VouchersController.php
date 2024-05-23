<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Color;
use App\Models\Vouchers;
use App\Models\Size;
use App\Models\ProductVariant;
use App\Models\Discounts;

use Illuminate\Support\Facades\Auth;
use App\Models\ProductDetails;
use App\Models\ProductCates;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Session;




class VouchersController extends Controller
{
    //
    public function view()
    {
        $Vouchers = Vouchers::all();
        return view('layout.vouchers', ['vouchers' => $Vouchers]);
    }
    ///
    public function uploadVouchers(){
        return view ('voucher.upload');
    }
    public function deleteVouchers($id)
    {

        try {
            DB::beginTransaction();
            $Vouchers = Vouchers::find($id);
            if (!$Vouchers) {
                return redirect()->back()->with('error', 'Vouchers not found.');
            }
            $Vouchers->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Vouchers deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Vouchers to delete product.');
        }
    }
    ///
    public function updateVouchers($id)
    {
        $Vouchers = Vouchers::find($id);
        return view('crud.vouchers', ['Vouchers' => $Vouchers]);
    }
    ///
    public function editVouchers(Request $request)
    {

        $validator = Validator::make($request->all(), [
            '_token' => 'required',
            'voucher_code' => 'string',
            'discount_value' => 'required',
            'voucher_quantity' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $startDatetime = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $request->input('start_datetime'))));
        $endDatetime = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $request->input('end_datetime'))));

        try {
            DB::beginTransaction();
            $voucher = Vouchers::find($request->input('voucher_id'));
            if (!$voucher) {
                return redirect()->back()->with('error', 'Voucher not found');
            }
            $voucher->update([
                'voucher_code' => $request->input('voucher_code'),
                'discount_value' => $request->input('discount_value'),
                'start_date' => $startDatetime,
                'end_date' => $endDatetime,
                'voucher_quantity' => $request->input('voucher_quantity'),
                'status' => $request->input('status'),
            ]);
            DB::commit();
            return redirect()->back()->with('success', 'Vouchers updated successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'update failed!');
        }
    }
    ///
    public function checkVouchers(Request $request)
    {
        $voucherCode = $request->input('voucher_code');
        $voucher = Vouchers::where('voucher_code', $voucherCode)
            ->where('voucher_quantity', '>', 0)
            ->where('status', 'Active') 
            ->orWhere('status', 'Used') 
            ->where('discount_value', '>', 0)
            ->first();
        if ($voucher) {
            $VoucherValue = $voucher->discount_value;
            if ($VoucherValue > 0) {
                $cart = Session::get('cart');
                $dataCart = Session::get('dataCart');
                $subtotal = 0;
                $totalWithoutVat = 0;
                $vatRate = 0;
                $totalDiscountAmount = 0;

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

                $newSubtotal = $subtotal;

                $voucherDiscount = ($newSubtotal * $VoucherValue) / 100;
                $totalDiscountAmount += $voucherDiscount;

                $vat = $subtotal * $vatRate;
                $cartQuantity = count($cart);
                $newSubtotal -= $voucherDiscount;
                $dataInVoucher = [
                    'newSubtotal' => $newSubtotal,
                    'voucherCode' => $voucherCode,
                    'VoucherValue' => $VoucherValue,
                    'totalDiscountAmount' => $totalDiscountAmount,
                ];
                $aruvoucher = [
                    'VoucherValue' => $VoucherValue,
                    'voucherCode' => $voucherCode,
                ];
                session()->put('aruvoucher', $aruvoucher);
                return response()->json([
                    'success' => true,
                    'dataInVoucher' => $dataInVoucher,
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Voucher không hợp lệ.'
            ]);
        }
    }


    ///
    public function edit(Request $request)
    {

        $validator = Validator::make($request->all(), [
            '_token' => 'required',
            'voucher_code' => 'string',
            'discount_value' => 'required',
            'voucher_quantity' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            DB::beginTransaction();
            $startDatetime = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $request->input('start_datetime'))));
            $endDatetime = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $request->input('end_datetime'))));

            $voucherCode = $request->input('voucher_code');
            if (Vouchers::where('voucher_code', $voucherCode)->exists()) {
                return redirect()->back()->with('error', 'Mã voucher đã tồn tại');
            } else {
                $Vouchers = new Vouchers();
                $Vouchers->voucher_code = $voucherCode;
                $Vouchers->discount_value = $request->input('discount_value');
                $Vouchers->start_date = $startDatetime;
                $Vouchers->end_date = $endDatetime;
                $Vouchers->voucher_quantity = $request->input('voucher_quantity');
                $Vouchers->status = $request->input('status');
                $Vouchers->save();
            }
            DB::commit();
            return redirect()->back()->with('success', 'successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'An error');
        }
    }
}
