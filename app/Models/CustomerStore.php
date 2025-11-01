<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerStore extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'location', 'store_hours', 'rating', 'is_active'];

    // Add this relationship method
    public function products()
    {
        return $this->belongsToMany(CustomerProduct::class, 'customer_product_prices', 'store_id', 'product_id')
                    ->withPivot('current_price', 'original_price', 'in_stock', 'is_discounted')
                    ->withTimestamps();
    }
}