<?php

namespace App\Dtos;

use App\Enums\PaymentsGateway;

class PaymentDetailsDto{
    public $order_id;
    public $transaction_id;
    public $status;
    public $amount;
    public $currency;
    public $payment_method;
    public $paid_at;
    public $transaction_details;

    public function __construct($paymentPayload, $orderId, $status, $gateway = PaymentsGateway::LEMONSQUEEZY->value)
    {
        if($gateway == PaymentsGateway::LEMONSQUEEZY->value) {
            $this->handleLemonsSqueezy($paymentPayload);
        }else{
            throw new \Exception('Payment gateway not supported');
        }
        $this->order_id = $orderId;
        $this->status = $status;
    }

    private function handleLemonsSqueezy($paymentPayload){
        $this->transaction_id = $paymentPayload['id'];
        $this->amount = $paymentPayload['attributes']['total'] / 100;
        $this->currency = $paymentPayload['attributes']['currency'];
        $this->payment_method = PaymentsGateway::LEMONSQUEEZY->value;
        $this->paid_at = $paymentPayload['attributes']['first_order_item']['created_at'];
        $this->transaction_details = $paymentPayload;
    }
}