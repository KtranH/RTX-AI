<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Payment extends Controller
{
    public function ShowPayment($price)
    {
        return view('User.Payment.Payment',compact('price'));
    }
}
