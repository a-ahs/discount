<?php

    namespace App\Support\Gateways;

use App\Models\Order;
use Illuminate\Http\Request;

    class Pasargard implements GatewayInterface
    {
        public function pay(Order $order, int $amount)
        {
            dd('pasargard');
        }

        public function verify(Request $request)
        {
            
        }

        public function getName()
        {
            
        }
    }
?>