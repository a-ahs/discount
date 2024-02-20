<?php

    namespace App\Support\Cost\Contract;

    interface CostInterface
    {
        public function getCost();
        public function getTotalCost();
        public function persianDescriptiopn();
        public function getSummary();
    }

?>