<?php

    namespace App\Services\Auth;

use App\Models\LoginToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

    class MagicAuthentication
    {
        const INVALID_TOKEN = 'token.invalid';
        const AUTHENTICATED = 'authenticated';
    
        public function __construct(protected Request $request)
        {    
        }

        public function requestLink()
        {
            $user = User::where('email', $this->request->email)->firstOrFail()->first();

            $user->createTokenForUser()->send([
                'remember' => $this->request->has('remember')
            ]);
        }

        public function authenticate(LoginToken $token)
        {
            if($token->isExpired())
            {
                return self::INVALID_TOKEN;
            }
            
            $token->delete();
            
            Auth::login($token->user, $this->request->query('remember'));
            return self::AUTHENTICATED;
        }
    }

?>