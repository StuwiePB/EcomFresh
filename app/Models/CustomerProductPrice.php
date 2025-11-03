<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerProductPrice extends Model
{
    use HasFactory;

    protected $table = 'customer_product_prices';

    protected $fillable = [
        'product_id',
        'store_id', 
        'current_price',
        'original_price',
        'in_stock',
        'stock',
        'is_discounted'
    ];

    public function product()
    {
        return $this->belongsTo(CustomerProduct::class, 'product_id');
    }

    public function store()
    {
        return $this->belongsTo(CustomerStore::class, 'store_id');
    }
}