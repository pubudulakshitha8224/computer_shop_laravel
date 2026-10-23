<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'customer_id',
        'product_name',
        'quantity',
        'total_price',
        'sale_date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}