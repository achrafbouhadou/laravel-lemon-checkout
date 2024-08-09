<?php

namespace App\Services\Order;

use App\Interfaces\Order\OrderStatusStrategyInterface;
use Illuminate\Support\Facades\Log;


class PaidOrderStrategy implements OrderStatusStrategyInterface
{
    public function handle(array $data): void
    {
        $orderId = $data['id'];
        $customerId = $data['attributes']['customer_id'];

        // Log the successful payment
        Log::info("Order $orderId for customer $customerId is paid.");

        // todo send email and update order status
    }
}
