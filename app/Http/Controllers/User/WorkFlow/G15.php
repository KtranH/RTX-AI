<?php

namespace App\Http\Controllers\User\WorkFlow;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class G15 extends Controller
{
    //
    public function InputDataG15()
    {
        Alert::error("Cảnh báo", "Chức năng đang tạm dừng hoạt động")->autoClose(5000);
        return redirect()->back();
    }
}
