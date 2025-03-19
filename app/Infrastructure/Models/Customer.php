<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'external_id',
        'first_name',
        'last_name',
        'username',
        'email',
        'age',
        'phone',
        'birth_date',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
