<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case FAILED = 'failed';
    case PAID = 'paid';
    case REFUNDED = 'refunded';
    case PARTIAL_REFUND = 'partial_refund';
}