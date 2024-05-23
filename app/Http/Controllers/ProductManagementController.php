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
use App\Models\User;
use App\Models\product_colors;
use App\Models\product_sizes;
use Illuminate\Support\Str;
use App\Models\product_variants;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Validator;
use App\Models\OrderItems;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProductManagementController extends Controller
{
    //
    public function customertable()
    {
        $customers = Customers::paginate(10);
        return view('dataview.customertable', ['customers' => $customers]);
    }
    public function customerdelete($id)
    {
        $customer = Customers::find($id);
        if (!$customer) {
            return redirect()->back()->with('error', 'Customer not found.');
        }
        $customer->delete();
        return redirect()->back()->with('success', 'Customer deleted successfully.');
    }
    public function customeredit($id)
    {
        $customers = Customers::find($id);
        dd($customers);
        return view('dataview.customertable', ['customers' => $customers]);
    }
    ///////////////////////
    public function order()
    {
        $datacustomer = DB::table('orders')
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->join('order_numbers', 'orders.order_number_id', '=', 'order_numbers.id')
            ->join('payment_methods', 'orders.payment_method_id', '=', 'payment_methods.id')
            ->select(
                'customers.id as customer_id',
                'customers.name as customer_name',
                'customers.email',
                'customers.address',
                'customers.phone',
                'customers.total_purchases',
                'orders.total_amount',
                'orders.status',
                'order_numbers.order_number',
                'payment_methods.name as payment_method'
            )
            ->get();
        return view('order.order', ['datacustomer' => $datacustomer]);
    }
    ///
    public function orderdetail($id, Request $request)
    {
        try {
        $status = $request->input('status');
        $datacustomer = DB::table('orders')
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->join('order_numbers', 'orders.order_number_id', '=', 'order_numbers.id')
            ->join('payment_methods', 'orders.payment_method_id', '=', 'payment_methods.id')
            ->leftJoin('vouchers', 'orders.voucher_id', '=', 'vouchers.id')
            ->select(
                'customers.id as customer_id',
                'customers.name as customer_name',
                'customers.email',
                'customers.address',
                'customers.phone',
                'customers.total_purchases',
                'orders.total_amount',
                'orders.total_discount',
                'orders.voucher_id',
                'orders.status',
                'orders.order_date',
                'order_numbers.order_number',
                'payment_methods.name as payment_method',
                'vouchers.discount_value as voucher_value'
            )
            ->where('orders.customer_id', $id)
            ->get();
        $orders = DB::table('orders')
            ->where('customer_id', $id)
            ->pluck('id');

        $orderItems = DB::table('order_items')
            ->whereIn('order_id', $orders)
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->leftJoin('colors', 'order_items.color_id', '=', 'colors.id')
            ->leftJoin('sizes', 'order_items.size_id', '=', 'sizes.id')
            ->leftJoin('product_variants', function ($join) {
                $join->on('order_items.product_id', '=', 'product_variants.product_id')
                    ->on('order_items.color_id', '=', 'product_variants.color_id')
                    ->on('order_items.size_id', '=', 'product_variants.size_id');
            })
            ->leftJoin('discounts', 'product_variants.discount_id', '=', 'discounts.id')
            ->select(
                'products.name as product_name',
                'order_items.price as order_item_price',
                'colors.color',
                'sizes.size',
                'order_items.quantity',
                DB::raw('COALESCE(discounts.discount, 0) as discount')
            )
            ->get();
        $datacus = [
            'orderItems' => $orderItems,
            'datacustomer' => $datacustomer,
        ];
        // dd($datacus);

        return view('order.detaillist', $datacus);
        } catch (\Exception $e) {
            return view('layout.error');
            // return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
