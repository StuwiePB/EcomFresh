<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceHistory extends Model
{
    use HasFactory;

    protected $table = 'price_history';

    protected $fillable = [
        'product_id',
        'current_price',
        'last_month_price',
        'two_months_ago_price',
        'three_months_ago_price',
        'recorded_date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
