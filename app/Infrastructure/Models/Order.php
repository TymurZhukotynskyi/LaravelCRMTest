<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'status_id',
        'unique_identifier',
        'total_amount',
        'total_products',
    ];

    protected $casts = [
        'total_amount' => 'float',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }
}
