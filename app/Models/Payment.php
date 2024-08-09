<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'transaction_id',
        'status',
        'amount',
        'currency',
        'payment_method',
        'paid_at',
        'transaction_details',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'transaction_details' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
