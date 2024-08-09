<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'total',
        'currency',
        'email',
        'name',
        'whatsapp_number',
        'order_items',
    ];

    protected $casts = [
        'order_items' => 'array',
    ];


    // one to many relationship cause one order has many payments
    // cause it could be  a failed payment and the user create new payment for the same order
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}