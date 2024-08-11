<?php

namespace App\Listeners;

use App\Events\OrderCreatedEvent;
use App\Services\Order\OrderService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderCreatedListener
{
    /**
     * Create the event listener.
     */
    public function __construct(private OrderService $orderService)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreatedEvent $event): void
    {
       try{
            info('OrderCreatedListener', [
                'paymentDetails' => $event->paymentDetails
            ]);
            $orderId = $event->paymentDetails->order_id;
            $status = $event->paymentDetails->status;
            $order = $this->orderService->updateOrderStatus($orderId, $status);
            $order->payments()->create([
                'order_id' => $order->id,
                'transaction_id' => $event->paymentDetails->transaction_id,
                'status' => $event->paymentDetails->status,
                'amount' => $event->paymentDetails->amount,
                'currency' => $event->paymentDetails->currency,
                'payment_method' => $event->paymentDetails->payment_method,
                'paid_at' => $event->paymentDetails->paid_at,
                'transaction_details' => $event->paymentDetails->transaction_details
            ]);
       }
       catch (\Exception $exception)
       {

       }
    }
}
