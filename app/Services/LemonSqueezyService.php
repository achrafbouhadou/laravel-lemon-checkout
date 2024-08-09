<?php

namespace App\Services;

use App\Strategies\Order\OrderStatusContext;
use Illuminate\Container\Attributes\Log;
use Illuminate\Support\Facades\Http;

class LemonSqueezyService
{

    protected $apiKey;
    protected $baseUrl = 'https://api.lemonsqueezy.com/v1';

    private OrderStatusContext $orderStatusContext;

    const WEBHOOK_ORDER_CREATED = 'order_created';

    public function __construct(OrderStatusContext $orderStatusContext)
    {
        $this->apiKey = config('services.lemonsqueezy.api_key');
        $this->orderStatusContext = $orderStatusContext;
    }

    public function createPaymentSession($data)
    {
        $response = Http::withToken($this->apiKey)
            ->post("{$this->baseUrl}/checkouts", [
                'data' => [
                    'type' => 'checkouts',
                    'attributes' => [
                        'store_id' => $data['store_id'],
                        'variant_id' => $data['variant_id'],
                        'custom_price' => $data['custom_price'] ?? null,
                        'product_options' => $data['product_options'] ?? null,
                        'checkout_data' => [
                            'name' => $data['name'],
                            'email' => $data['email'],
                            'billing_address' => $data['billing_address'] ?? null,
                            'tax_number' => $data['tax_number'] ?? null,
                            'discount_code' => $data['discount_code'] ?? null,
                        ],
                    ],
                ],
            ]);

        return $response->json();
    }

    public function handleWebhook($payload, $signature)
    {
        $secret = config('services.lemonsqueezy.webhook_secret');

        if (!$this->verifyWebhookSignature($payload, $signature, $secret)) {
            throw new \Exception('Invalid webhook signature');
        }

        $event = json_decode($payload, true);

        if($event['meta']['event_name'] == self::WEBHOOK_ORDER_CREATED) {
            $this->handleOrderCreated($event['data']);
        }
    }

    protected function verifyWebhookSignature($payload, $signature, $secret)
    {
        $computedSignature = hash_hmac('sha256', $payload, $secret);
        return hash_equals($computedSignature, $signature);
    }

    protected function handleOrderCreated($orderData)
    {
        $status = $orderData['attributes']['status'];

        try {
            $orderStatusStrategy = $this->orderStatusContext->determineStrategy($status);
            $this->orderStatusContext->setStrategy($orderStatusStrategy);
            $this->orderStatusContext->handleOrder($orderData);
        } catch (\Exception $e) {
            info('Error handling order status: ' . $e->getMessage());
        }
    }

    
}
