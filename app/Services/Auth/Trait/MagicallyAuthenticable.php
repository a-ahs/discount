<?php

    namespace App\Services\Auth\Trait;

use App\Models\LoginToken;
use Illuminate\Support\Str;

    trait MagicallyAuthenticable
    {
        public function magicToken()
        {
            return $this->hasOne(LoginToken::class);
        }

        public function createTokenForUser()
        {
            $this->magicToken()->delete();

            return $this->magicToken()->create([
                'token' => Str::random(50)
            ]);
        }
    }

?>