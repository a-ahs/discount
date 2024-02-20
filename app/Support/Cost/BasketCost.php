<?php

    namespace App\Support\Cost;

use App\Support\Basket\Basket;
use App\Support\Cost\Contract\CostInterface;

    class BasketCost implements CostInterface
    {
        public function __construct(private Basket $basket)
        {
        }
        
        public function getCost()
        {
            return $this->basket->subTotal();   
        }

        public function getTotalCost()
        {
            return $this->getCost();
        }

        public function persianDescriptiopn()
        {
            return 'سبد خرید';
        }

        public function getSummary()
        {
            return [$this->persianDescriptiopn() => $this->getCost()];
        }
    }

?>