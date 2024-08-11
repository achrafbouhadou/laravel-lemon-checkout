<?php

namespace App\Services\Order;

use App\Interfaces\Order\OrderStatusStrategyInterface;
use App\Mail\OrderPaidMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PaidOrderStrategy implements OrderStatusStrategyInterface
{
    public function handle(array $data): void
    {
        $customerEmail = $data['attributes']['user_email'];
        // Log the successful payment
        // Send the order paid email
        Log::info('Order paid successfully');
        // the LemonSqueezyService send the email automatically with download file and invoice 
        // but if we need to send custom mail we could deactivate it in the LemonSqueezyService and send it 
        Mail::to($customerEmail)->queue(new OrderPaidMail($data));

    }
}
