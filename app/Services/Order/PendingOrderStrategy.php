<?php

namespace App\Services\Order;

use App\Interfaces\Order\OrderStatusStrategyInterface;
use Illuminate\Support\Facades\Log;

class PendingOrderStrategy implements OrderStatusStrategyInterface
{
    public function handle(array $data): void
    {
        $orderId = $data['id'];
        $customerId = $data['attributes']['customer_id'];
        $productDetails = $data['attributes']['first_order_item'];

        // Log the pending status
        Log::info("Order $orderId for customer $customerId is pending.");

    }
}
