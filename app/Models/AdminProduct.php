<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminProduct extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'category', 'price', 'stock'];
}
