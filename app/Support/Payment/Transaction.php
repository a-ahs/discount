<?php

    namespace App\Support\Payment;

use App\Events\OrderRegistered;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Str;
use App\Support\Basket\Basket;
use App\Support\Cost\Contract\CostInterface;
use App\Support\Gateways\GatewayInterface;
use App\Support\Gateways\Pasargard;
use App\Support\Gateways\Saman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SoapClient;

    class Transaction
    {
        public function __construct(private Request $request, private Basket $basket, private CostInterface $cost)
        {
        }

        public function checkout()
        {
            DB::beginTransaction();

            try {
                $order = $this->makeOrder();
                $order->generateInvoice();

                $payment = $this->makePayment($order);
                DB::commit();

            } catch (\Exception $e) {
                DB::rollBack();
                dd($e);
                return null;
            }

            if($payment->isOnline())
            {
                return $this->gatewayFactory()->pay($order, $this->cost->getTotalCost());
            }

            $this->complete($order);

            return $order;
        }

        public function verify()
        {
            $result = $this->gatewayFactory()->verify($this->request);

            if($result['status'] == GatewayInterface::TRANSACTION_FAILED) return false;

            $result['order']->payment->confirm($result['refNum'], $result['gateway']);

            $this->complete($result['order']);

            return true;
        }

        public function pay($order)
        {
            return $this->gatewayFactory()->pay($order, $order->payment->amount);
        }

        private function complete($order)
        {
            $this->normalizeQuantity($order);

            event(new OrderRegistered($order));

            $this->basket->clear();
        }

        private function normalizeQuantity($order)
        {
            foreach($order->products as $product)
            {
                $product->decrementStock($product->pivot->quantity);
            }
        }

        private function gatewayFactory()
        {
            if(!$this->request->has('gateway')) return resolve(Saman::class);

            $gateway = [
                'saman' => Saman::class,
                'pasargard' => Pasargard::class
            ][$this->request->gateway];

            return resolve($gateway); 
        }

        private function makeOrder()
        {
            $order = Order::create([
                'user_id' => auth()->user()->id,
                'amount'  => $this->basket->subTotal(),
                'code'    => bin2hex(Str::random(16)), 
            ]);

            $order->products()->attach($this->products());

            return $order;
        }

        private function products()
        {
            $products = [];
            foreach($this->basket->all() as $product)
            {
                $products[$product->id] = ['quantity' => $product->quantity];
            }
            
            return $products;
        }
        
        private function makePayment($order)
        {
            return Payment::create([
                'order_id' => $order->id,
                'method' => $this->request->method,
                'amount' => $this->cost->getTotalCost(),
            ]);
        }
    }

?>