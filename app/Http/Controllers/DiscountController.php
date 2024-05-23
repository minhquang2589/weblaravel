<?php

namespace App\Http\Controllers;

use App\Models\Discounts;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;



class DiscountController extends Controller
{
    //
    public function discountView()
    {
        $discount = Discounts::all();
        return view('discount.discount', [
            'discounts' => $discount,
        ]);
    }
    ///
    public function discountEdit(Request $request)
    {
        $discount = Discounts::find($request->input('discount_id'));
        return view('discount.discountEdit', ['discountEdit' => $discount]);
    }
    ///
    public function discountUpdate(Request $request)
    {
        try {
            DB::beginTransaction();
            $discountId = $request->input('discount_id');
            $status = $request->input('status');
            $discount = Discounts::find($discountId);
            $startDatetime = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $request->input('start_datetime'))));
            $endDatetime = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $request->input('end_datetime'))));

            if ($discount) {
                $discount->start_datetime = $startDatetime;
                $discount->end_datetime = $endDatetime;
                $discount->discount = $request->input('discountnumber');
                $discount->quantity =  $request->input('discountquantity');
                $discount->remaining =  $request->input('remaining');
                $discount->status =  $status;
                $discount->save();
            } 
            DB::commit();
            return redirect()->back()->with('success', 'Discount uploaded successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'An error occurred while uploading the Discount.');
        }
    }
}
