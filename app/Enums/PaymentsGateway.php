<?php

namespace App\Enums;

enum PaymentsGateway: string
{
    case STRIPE = 'stripe';
    case PAYPAL = 'paypal';
    case LEMONSQUEEZY = 'lemonsqueezy';
}