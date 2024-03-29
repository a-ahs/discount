<?php

    namespace App\Support\Discount\Coupon\Validator;

use App\Exceptions\CouponHasExpiredException;
use App\Models\Coupon;
    use App\Support\Discount\Coupon\Validator\Contracts\AbstractCouponValidator;

    class IsExpired extends AbstractCouponValidator
    {
        public function validate(Coupon $coupon)
        {
            if($coupon->isExpired())
            {
                throw new CouponHasExpiredException();
            }

            return parent::validate($coupon);
        }
    }
?>