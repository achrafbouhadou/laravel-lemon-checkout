<?php

namespace App\Services;

use App\Dtos\PaymentDetailsDto;
use App\Enums\OrderStatus;
use App\Events\OrderCreatedEvent;
use App\Strategies\Order\OrderStatusContext;

use Illuminate\Support\Facades\Http;
use App\Interfaces\IPaymentMethod;
use Illuminate\Support\Facades\Log ;

class LemonSqueezyService implements IPaymentMethod
{

    protected $apiKey;
    protected $baseUrl = 'https://api.lemonsqueezy.com/v1';
    protected $redirectUrl;

    private OrderStatusContext $orderStatusContext;

    const WEBHOOK_ORDER_CREATED = 'order_created';

    public function __construct(OrderStatusContext $orderStatusContext)
    {
        $this->apiKey = config('services.lemonsqueezy.api_key');
        $this->orderStatusContext = $orderStatusContext;

        $this->redirectUrl = config('app.url').'/thank-you';
    }

    public function createPaymentSession($data)
    {
        try{
            $response = Http::withToken($this->apiKey)
            ->post("{$this->baseUrl}/checkouts", [
                'data' => [
                    'type' => 'checkouts',
                    'attributes' => [
                        'product_options' => [
                            'redirect_url' => $this->redirectUrl,
                        ],
                        'checkout_data' => [
                            'name' => $data['name'],
                            'email' => $data['email'],
                            'custom' => [
                                'order_id' => strval($data['order_id']),
                            ],
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
        catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new \Exception($e->getMessage());
        }
        
    }

    public function handleWebhook($payload, $signature)
    {
        $secret = config('services.lemonsqueezy.webhook_secret');

        if (!$this->verifyWebhookSignature($payload, $signature, $secret)) {
            throw new \Exception('Invalid webhook signature');
        }

        $event = json_decode($payload, true);

        if($event['meta']['event_name'] == self::WEBHOOK_ORDER_CREATED) {
            $this->handleOrderCreatedEvent($event['data'], $event['meta']['custom_data']['order_id']);
        }
    }

    protected function verifyWebhookSignature($payload, $signature, $secret)
    {
        $computedSignature = hash_hmac('sha256', $payload, $secret);
        return hash_equals($computedSignature, $signature);
    }

    protected function handleOrderCreatedEvent($orderData, $orderId)
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
            $details = new PaymentDetailsDto($orderData, $orderId, $status);
            event(new OrderCreatedEvent($details));
            $this->orderStatusContext->handleOrder($orderData);
        } catch (\Exception $e) {
            info('Error handling order status: ' . $e->getMessage());
        }
    }

    
}
