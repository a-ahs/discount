<?php

    namespace App\Support\Gateways;

use App\Models\Order;
use Illuminate\Http\Request;

    class Saman implements GatewayInterface
    {
        private $merchantID;
        private $callback;

        public function __construct()
        {
            $this->merchantID = '452585658';
            $this->callback = route('payment.verify', $this->getName());
        }

        public function pay(Order $order, $amount)
        {
            $this->redirectToBank($order, $amount);
        }

        public function verify(Request $request)
        {
            // if(!$request->has('Status') || $request->input('Status') !== 'OK')
            // {
            //     return $this->transactionFailed();
            // }


            // $soapClient = new SoapClient();
            // $response = $soapClient->VerifyTransaction($request->input('refNum'), $this->merchantID);
            
            $order = $this->getOrder($request->input('ResNum'));
            $response = $order->payment->amount;

            $request->merge(['RefNum' => '45852525']);

            return $response == $order->payment->amount
            ? $this->transactionSuccess($order, $request->input('RefNum'))
            : $this->transactionFailed();
        }

        public function getName()
        {
            return 'saman';
        }

        private function getOrder($resNum)
        {
            return Order::where('code', $resNum)->firstOrFail();
        }

        private function transactionSuccess($order, $refNum)
        {
            return [
              'status' => self::TRANSACTION_SUCCESS,
              'order' => $order,
              'refNum' => $refNum,
              'gateway' => $this->getName()
            ];
        }

        private function transactionFailed()
        {
            return [
                'status' => self::TRANSACTION_FAILED
            ];
        }

        private function redirectToBank($order, $amount)
        {
            echo "<form id='samanpeyment' action='https://sep.shaparak.ir/payment.aspx' method='post'>
            <input type='hidden' name='Amount' value='{$amount}' />
            <input type='hidden' name='ResNum' value='{$order->code}'>
            <input type='hidden' name='RedirectURL' value='{$this->callback}'/>
            <input type='hidden' name='MID' value='{$this->merchantID}'/>
            </form><script>document.forms['samanpeyment'].submit()</script>";
        }
    }
?>