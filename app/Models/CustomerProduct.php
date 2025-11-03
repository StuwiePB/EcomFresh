<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerProduct extends Model
{
    use HasFactory;

    // In app/Models/CustomerProduct.php
protected $fillable = [
    'category_id', 'name', 'slug', 'description', 
    'image', 'unit', 'stock', 'status', 'is_active'
];

    

    // Add these relationship methods
    public function category()
    {
        return $this->belongsTo(CustomerCategory::class, 'category_id');
    }

    public function stores()
    {
        return $this->belongsToMany(CustomerStore::class, 'customer_product_prices', 'product_id', 'store_id')
                    ->withPivot('current_price', 'original_price', 'in_stock', 'is_discounted')
                    ->withTimestamps();
                    
    }

    public function favorites()
    {
        return $this->hasMany(CustomerFavorite::class, 'product_id');
    }
    
}
