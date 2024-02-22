<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_code',
        'order_number',
        'status'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_code', 'customer_code');
    }

    public function details()
    {
        return $this->belongsTo(OrderDetail::class, 'order_number', 'order_number');
    }
}
