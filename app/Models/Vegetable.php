<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vegetable extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vegetables';

    // ✅ Include all fields used in CRUD and forms
    protected $fillable = [
        'name',
        'category',
        'price',
        'stock',
        'description',
        'image',
        'status',
    ];

    // ✅ Data type casting for proper formatting
    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // ✅ Scope to get items that are in stock and active
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0)
                     ->where('status', 'active');
    }
}
