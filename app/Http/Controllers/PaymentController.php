<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\LemonSqueezyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class PaymentController extends Controller
{
    
    protected LemonSqueezyService $lemonSqueezyService;
    public function __construct(LemonSqueezyService $lemonSqueezyService)
    {
        $this->lemonSqueezyService = $lemonSqueezyService;
    }

    public function show($product_id)
    {
        try{
            $product = Product::findOrFail($product_id);
            return Inertia::render('Payment/CheckoutPage', [
                'product' => $product,
            ]);

        }catch(\Exception $e){
            Log::error($e->getMessage());
            return back()->withErrors(['message' => 'Oops! We encountered an issue while processing your request. Please try again or contact support if the problem persists.']);
        }
        
    }

    public function checkout(Request $request )
    {
        $paymentSession = $this->lemonSqueezyService->createPaymentSession([]);

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

}
