<?php

namespace App\Http\Controllers;

use App\Support\Payment\Transaction;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(private Transaction $transaction)
    {
    }

    public function verify()
    {
        $result = $this->transaction->verify();

        return $result 
        ? $this->sendSuccessResponse()
        : $this->sendFailedResponse();
    }

    private function sendFailedResponse()
    {
        return redirect()->route('products.index')->with('failed', 'مشکلی در ثبت سفارش بوجود آمده');        
    }

    private function sendSuccessResponse()
    {
        return redirect()->route('products.index')->with('success', 'سفارش شما با موفقیت ایجاد شد');        
    }
}
