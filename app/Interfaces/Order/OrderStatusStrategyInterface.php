<?php

namespace App\Interfaces\Order;

interface OrderStatusStrategyInterface
{
    public function handle(array $data): void;
}