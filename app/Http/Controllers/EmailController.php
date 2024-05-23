<?php

namespace App\Http\Controllers;

use App\Mail\sendMail;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;

class EmailController extends Controller
{
    //
    public function sendMail(
        $orderDate,
        $element,
        $orderNumber,
        $cart,
        $DETACheckout
    ) {
        $response = Mail::to($element['email'])->send(new sendMail(
            $orderDate,
            $element,
            $orderNumber,
            $cart,
            $DETACheckout
        ));
    }
}
