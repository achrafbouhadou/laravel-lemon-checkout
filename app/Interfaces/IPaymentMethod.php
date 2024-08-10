<?php

namespace App\Interfaces;
use Illuminate\Support\Arr;

interface IPaymentMethod
{
    public function createPaymentSession(array $data);
    public function handleWebhook(Array $payload, String $signature);
}