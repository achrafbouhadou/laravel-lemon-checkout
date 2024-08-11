<?php

namespace App\Services\Order;

use App\Interfaces\Order\OrderStatusStrategyInterface;
use App\Mail\OrderFailedMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class FailedOrderStrategy implements OrderStatusStrategyInterface
{
    public function __construct() {
        
    }
    public function handle(array $data): void
    {
        $customerEmail = $data['attributes']['user_email'];

        // Send the order failed email
        Mail::to($customerEmail)->queue(new OrderFailedMail($data));

    }
}
