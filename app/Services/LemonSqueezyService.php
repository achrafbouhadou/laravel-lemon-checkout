<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Strategies\Order\OrderStatusContext;
use Illuminate\Container\Attributes\Log;
use Illuminate\Support\Facades\Http;
use App\Interfaces\IPaymentMethod;

class LemonSqueezyService implements IPaymentMethod
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
                        'product_options' => [
                            'redirect_url' => 'http://laravel-lemon-checkout.test/',
                        ],
                        'checkout_data' => [
                            'name' => $data['name'],
                            'email' => $data['email'],
                        ],
                    ],
                    'relationships' => [
                        'store' => [
                            'data' => [
                                'type' => 'stores',
                                'id' => $data['store_id']
                            ]
                        ],
                        'variant' => [
                            'data' => [
                                'type' => 'variants',
                                'id' => $data['variant_id']
                            ]
                        ]
                    ]
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
        try {
            $statusString = $orderData['attributes']['status'];
            // Convert to enum
            $status = OrderStatus::from(strtolower($statusString)); // exemple  Convert "paid" to OrderStatus::PAID
            if (!$status) {
                throw new \Exception('Invalid order status');
            }
            $orderStatusStrategy = $this->orderStatusContext->determineStrategy($status);
            $this->orderStatusContext->setStrategy($orderStatusStrategy);
            $this->orderStatusContext->handleOrder($orderData);
        } catch (\Exception $e) {
            info('Error handling order status: ' . $e->getMessage());
        }
    }

    
}
