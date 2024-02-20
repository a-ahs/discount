<?php

    namespace App\Services\Notification\Providers;

    use App\Models\User;
use App\Services\Notification\Contract\Provider;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

    class EmailProvider implements Provider
    {
        public function __construct(private User $user, private Mailable $mailable)
        {     
        }

        public function send()
        {
            Mail::to($this->user)->send($this->mailable);
        }
    }
?>