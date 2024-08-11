<?php

namespace App\Services\Order;

use App\Interfaces\Order\OrderStatusStrategyInterface;
use Illuminate\Support\Facades\Log;


class PartialRefundOrderStrategy implements OrderStatusStrategyInterface
{
    public function handle(array $data): void
    {
        $orderId = $data['id'];
        $customerId = $data['attributes']['customer_id'];

        // Log the partial refund
        Log::info("Order $orderId for customer $customerId has received a partial refund.");

        // handle partial refund
    }
}
