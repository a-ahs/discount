<?php

    namespace App\Support\Discount;

use App\Support\Cost\BasketCost;

    class DiscountManager
    {
        public function __construct(private BasketCost $cost, private DiscountCalculator $calculator)
        {
            
        }

        public function calculateUserDiscount()
        {
            if(!session()->has('coupon')) return 0;

            return $this->calculator->discountAmount(session()->get('coupon'), $this->cost->getTotalCost());
        }
    }
?>