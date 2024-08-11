<?php

namespace App\Services\Order;

use App\Interfaces\Order\OrderStatusStrategyInterface;
use Illuminate\Support\Facades\Log;


class FailedOrderStrategy implements OrderStatusStrategyInterface
{
    public function __construct() {
        
    }
    public function handle(array $data): void
    {
        $orderId = $data['id'];
        $customerId = $data['attributes']['customer_id'];

        // Log the failed payment
        Log::warning("Order $orderId for customer $customerId has failed.");

        // todo send email and update order status
    }
}
