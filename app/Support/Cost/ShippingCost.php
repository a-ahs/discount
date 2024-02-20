<?php

    namespace App\Support\Cost;

    use App\Support\Cost\Contract\CostInterface;

    class ShippingCost implements CostInterface
    {
        const SHIPPING_COST = 20000;

        public function __construct(private CostInterface $cost)
        {
        }

        public function getCost()
        {
            return self::SHIPPING_COST;
        }

        public function getTotalCost()
        {
            return $this->cost->getTotalCost() + $this->getCost();
        }

        public function persianDescriptiopn()
        {
            return 'هزینه حمل و نقل';
        }

        public function getSummary()
        {
            return array_merge($this->cost->getSummary(), [$this->persianDescriptiopn() => $this->getCost()]);
        }
    }
?>