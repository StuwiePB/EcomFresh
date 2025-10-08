<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vegetable extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vegetables';
    protected $fillable = ['name','price','stock','description','image','status'];
    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }
}
