<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Product;
use App\Services\LemonSqueezyService;
use App\Services\Order\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class PaymentController extends Controller
{
    
    protected LemonSqueezyService $lemonSqueezyService;
    protected OrderService  $orderService;
    public function __construct(LemonSqueezyService $lemonSqueezyService , OrderService $orderService)
    {
        $this->lemonSqueezyService = $lemonSqueezyService;
        $this->orderService = $orderService;
    }

    public function show($product_id)
    {
        try{
            // always asuming that we can purchase just one product
            $product = Product::findOrFail($product_id);
            return Inertia::render('Payment/CheckoutPage', [
                'product' => $product,
            ]);

        }catch(\Exception $e){
            Log::error($e->getMessage());
            return back()->withErrors(['message' => 'Oops! We encountered an issue while processing your request. Please try again or contact support if the problem persists.']);
        }
        
    }

    public function checkout(OrderRequest $request) 
    {

        $orderProduct = $this->orderService->createOrder($this->getRequestData($request->validated()));
        $request->session()->put('order_id', $orderProduct['order']->id);
        if($request->payment_method == 'stripe') {
            // todo later
            return back()->withErrors(['message' => 'stripe payment method not implemented yet']);

        }elseif($request->payment_method == 'paypal') {
            // todo later
            return back()->withErrors(['message' => 'paypal payment method not implemented yet']);
            
        }elseif($request->payment_method == 'lemonsqueezy') {
            $paymentSession = $this->lemonSqueezyService->createPaymentSession($this->buildPaymentData($request , $orderProduct['product']));
        }else{
            return back()->withErrors(['message' => 'you need to select a valid payment method']);
        }

        // Check if the payment session was created successfully
        if (isset($paymentSession['data']['attributes']['url'])) {
            return Inertia::location($paymentSession['data']['attributes']['url']);
        } else {
            return back()->withErrors(['message' => 'Oops! We encountered an issue while processing your request. Please try again or contact support if the problem persists.']);
        }
    }

    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $signature = $request->header('X-Signature');
        try {
            $this->lemonSqueezyService->handleWebhook($payload, $signature);
            return response()->json(['success'=>true, 'message' => 'Webhook processed successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['success'=>false, 'error' => $e->getMessage()], 400);
        }
    }

    protected function getRequestData($data)
    {
        return [
            'name' => $data['name'],
            'email' => $data['email'],
            'whatsapp' => $data['whatsapp'],
            'product_id' => $data['product_id'], // asuming that we can purchase just one product
        ];
    }

    protected function buildPaymentData($data , $product)
    {
        return [
            'store_id' => config('services.lemonsqueezy.store_id'),
            'variant_id' =>  $product->lemonsqueezy_variant_id,
            'name' => $data['name'],
            'email' => $data['email'],
            'price' => $product->price * 1, // todo handle quantity
        ];
    }
    public function  thankYou(Request $request)
    {
        $order = $this->orderService->getOrderBySessionId($request->session()->get('order_id'));

        return Inertia::render('Payment/ThankYouPage' , 
        [
            'orderNumber' => $order->id,
            'date' => $order->created_at->format('F d, Y'),
            'email' => $order->email,
            'name' => $order->name,
            'total' => number_format($order->total, 2),
        ]);
    }

}
