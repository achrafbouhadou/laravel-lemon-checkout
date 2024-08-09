<?php

namespace App\Strategies\Order;

use App\Enums\OrderStatus;
use App\Interfaces\Order\OrderStatusStrategyInterface;
use App\Services\Order\FailedOrderStrategy;
use App\Services\Order\PaidOrderStrategy;
use App\Services\Order\PartialRefundOrderStrategy;
use App\Services\Order\PendingOrderStrategy;
use App\Services\Order\RefundedOrderStrategy;
use Exception;
use Illuminate\Support\Facades\App;

class OrderStatusContext
{
    private OrderStatusStrategyInterface $strategy;

    public function setStrategy(OrderStatusStrategyInterface $strategy): void
    {
        $this->strategy = $strategy;
    }

    public function handleOrder(array $data): void
    {
        $this->strategy->handle($data);
    }

    public function determineStrategy(OrderStatus $status): OrderStatusStrategyInterface
    {
        return match ($status) {
            OrderStatus::PENDING => App::make(PendingOrderStrategy::class),
            OrderStatus::FAILED => App::make(FailedOrderStrategy::class),
            OrderStatus::PAID => App::make(PaidOrderStrategy::class),
            OrderStatus::REFUNDED => App::make(RefundedOrderStrategy::class),
            OrderStatus::PARTIAL_REFUND => App::make(PartialRefundOrderStrategy::class),
            default => throw new Exception("Unsupported order status [$status->value]"),
        };
    }
}
