<?php

    namespace App\Services\Notification\Providers;

use App\Exceptions\UserDoesNotHaveNumber;
use App\Models\User;
use App\Services\Notification\Contract\Provider;
use Kavenegar\KavenegarApi;

    class SmsProvider implements Provider
    {
        public function __construct(private User $user,private string $message)
        {
        }

        public function send()
        {
            $api = new KavenegarApi(config('services.sms.api'));
            $sender = env('Sender');
            $this->userHaveValidPhoneNumber();
            $receptor = $this->user->phone_number;
            $api->Send($sender,$receptor,$this->message);
        }

        private function userHaveValidPhoneNumber()
        {
            if(is_null($this->user->phone_number))
            {
                throw new \Exception('User does not have phone number');
            }
        }
    }

?>