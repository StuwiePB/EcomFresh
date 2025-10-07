<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beef extends Model
{
    use HasFactory;

     protected $table = 'beefs'; // optional if you follow Laravel naming convention
    protected $fillable = ['name', 'price', 'stock'];
}
