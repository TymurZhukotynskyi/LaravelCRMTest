<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $fillable = [
        'order_id',
        'external_product_id',
        'name',
        'price',
        'description',
        'quantity',
    ];

    protected $casts = [
        'price' => 'float',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
