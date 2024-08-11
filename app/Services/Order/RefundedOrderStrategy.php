<?php

namespace App\Services\Order;

use App\Interfaces\Order\OrderStatusStrategyInterface;
use Illuminate\Support\Facades\Log;


class RefundedOrderStrategy implements OrderStatusStrategyInterface
{
    public function handle(array $data): void
    {
        $orderId = $data['id'];
        $customerId = $data['attributes']['customer_id'];

        // Log the refund
        Log::info("Order $orderId for customer $customerId has been refunded.");

        // handle refund
       
    }
}
