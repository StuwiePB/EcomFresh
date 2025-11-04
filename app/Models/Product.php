<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // ✅ Allow mass-assignment for these columns
    protected $fillable = [
        'store_name',
        'name',
        'price',
        'description',
    ];

    // ✅ Optional: automatically scope every query by current store
    protected static function booted()
    {
        static::addGlobalScope('store', function ($query) {
            if (auth()->check()) {
                $query->where('store_name', auth()->user()->store_name);
            }
        });
    }

    // Relationship to price history records
    public function priceHistories()
    {
        return $this->hasMany(PriceHistory::class);
    }
}
