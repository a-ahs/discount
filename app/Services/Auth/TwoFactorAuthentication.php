<?php

    namespace App\Services\Auth;

use App\Models\TwoFactor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

    class TwoFactorAuthentication
    {
        const CODE_SENT = 'code.sent';
        const INVALID_CODE = 'code.invalid';
        const ACTIVATE = 'code.activated';
        const AUTHENTICATED = 'code.authenticated';
        protected $code;

        public function __construct(protected Request $request)
        {
        }

        public function requestCode(User $user)
        {
            $code = TwoFactor::generateCodeForUser($user);

            $code->send();
            $this->setSession($code);
            return static::CODE_SENT;
        }

        public function activate()
        {
            if(!$this->isValid()) return static::INVALID_CODE;
            $this->getToken()->delete();
            $this->getUser()->activateTwoFactor();    
            $this->forgetSession();

            return static::ACTIVATE;
        }

        public function deactivate(User $user)
        {
            $user->deactivateTwoFactor();
        }

        public function login()
        {
            if(!$this->isValid()) return static::INVALID_CODE;
            $this->getToken()->delete();
            $user = $this->getUser();
            Auth::login($user, session('remember'));

            $this->forgetSession();

            return static::AUTHENTICATED;
        }

        public function resent()
        {
            return $this->requestCode($this->getUser());
        }

        protected function isValid()
        {
            return !$this->getToken()->isExpired() && $this->getToken()->isEqualWith($this->request->code);
        }

        protected function setSession($code)
        {
            return session([
                'code_id' => $code->id,
                'user_id' => $code->user_id,
                'remember' => $this->request->remember,
            ]);
        }

        protected function getToken()
        {
            return $this->code ?? TwoFactor::findOrFail(session('code_id'));
        }

        protected function getUser()
        {
            return User::findOrFail(session('user_id'));
        }

        protected function forgetSession()
        {
            session(['user_id', 'code_id']);
        }
    }

?>