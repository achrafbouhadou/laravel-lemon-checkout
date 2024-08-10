<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Models\OrderLineItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB ;
use Illuminate\Support\Facades\Log;

class OrderService
{
    public function createOrder(array $data)
    {
        DB::beginTransaction();

        try {
            // assuming that we could purchase just one product each time
            $product = Product::find($data['product_id']);
            // Create the order
            $order = Order::create([
                'status' => 'processing',
                'total' =>  $product->price * 1,
                'currency' =>  'USD', // assuming USD is the store  currency
                'email' => $data['email'],
                'name' => $data['name'],
                'whatsapp_number' => $data['whatsapp'] ?? null,
            ]);
            // Create a single order line item
            OrderLineItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_price' => $product->price,
                'quantity' => $data['quantity'] ?? 1, // todo handel quantity
                'total_price' => $product->price * 1,
            ]);

            DB::commit();

            return [
                'order' => $order,
                'product' => $product,
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order creation failed: ' . $e->getMessage());
            throw $e;
        }
    }
    public function getOrderBySessionId($orderId)
    {
        return Order::where('id', $orderId)->firstOrFail();
    }
}