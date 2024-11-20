<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Payment extends Controller
{
    public function ShowPayment($price)
    {
        return view('User.Payment.Payment',compact('price'));
    }
    public function ShowPaymentSuccess()
    {
        Alert::success('Thanh toán thành công!')->autoClose(3000);
        $user = DB::table('users')->where('id', Auth::user()->id)->increment('times', 10);
        return redirect()->route('showboard');
    }
}
