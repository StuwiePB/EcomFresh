<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'image', 'icon', 'is_active'];

    // Add this relationship method
    public function products()
    {
        return $this->hasMany(CustomerProduct::class, 'category_id');
    }
}