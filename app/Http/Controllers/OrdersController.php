<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Support\Payment\Transaction;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function __construct(private Transaction $transaction)
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = auth()->user()->orders;

        return view('order.index', compact('orders'));
    }

    public function pay(Order $order)
    {
        return $this->transaction->pay($order);
    }
}
