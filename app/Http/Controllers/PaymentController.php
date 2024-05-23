<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;

class PaymentController extends Controller
{
    //
    // public function index()
    // {
    //     return view('layout.payment');
    // }
    /////

    public function paymentwithmeet()
    {

        return view('payment.meet');
    }
    public function paymentwithqr()
    {
        return view('payment.qr');
    }
    public function paymentwithbank()
    {
        return view('payment.bank');
    }
    public function paymentwithpaypal()
    {
        return view('payment.paypal');
    }
}
