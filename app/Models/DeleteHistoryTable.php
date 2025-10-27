<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeleteHistoryTable extends Model
{
    // ✅ Table name should match the database table (use lowercase plural)
    protected $table = 'delete_histories';

    // ✅ These are the columns that can be mass assigned
    protected $fillable = [
        'name',
        'category',
        'quantity',
        'deleted_at',
    ];

    // ✅ Keep timestamps enabled
    public $timestamps = true;
}
