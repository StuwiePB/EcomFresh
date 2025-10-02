<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'category',
        'price',
        'stock',
        'description',
        'image',
        'is_discounted',
        'discount_price',
        'status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'stock' => 'integer',
        'is_discounted' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Available categories for products
     */
    public static function getCategories()
{
    return [
        [
            'name' => 'Chicken',
            'description' => 'Fresh poultry products',
            'image' => 'images/categories/chicken.jpg' 
        ],
        [
            'name' => 'Beef', 
            'description' => 'Quality beef selections',
            'image' => 'images/categories/beef.jpg' // ← ADD THIS
        ],
        [
            'name' => 'Vegetables',
            'description' => 'Farm-fresh vegetables',
            'image' => 'images/categories/vegetables.jpg' // ← ADD THIS
        ],
        [
            'name' => 'discounted',
            'description' => 'Special offers and discounts',
            'image' => 'images/categories/discounted.jpg' // ← ADD THIS
        ]
    ];
}

    /**
     * Get category names as array
     */
    public static function getCategoryNames()
    {
        return array_column(self::getCategories(), 'name');
    }

    /**
     * Scope a query to only include products in a specific category.
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope a query to only include discounted products.
     */
    public function scopeDiscounted($query)
    {
        return $query->where('is_discounted', true);
    }

    /**
     * Scope a query to only include in-stock products.
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Scope a query to only include out-of-stock products.
     */
    public function scopeOutOfStock($query)
    {
        return $query->where('stock', '<=', 0);
    }

    /**
     * Get the final price (considering discounts)
     */
    public function getFinalPriceAttribute()
    {
        return $this->is_discounted && $this->discount_price 
            ? $this->discount_price 
            : $this->price;
    }

    /**
     * Check if product is available
     */
    public function getIsAvailableAttribute()
    {
        return $this->stock > 0 && $this->status === 'active';
    }

    /**
     * Get discount percentage if applicable
     */
    public function getDiscountPercentageAttribute()
    {
        if ($this->is_discounted && $this->discount_price && $this->price > 0) {
            return round((($this->price - $this->discount_price) / $this->price) * 100);
        }
        return 0;
    }

    /**
     * Update product stock
     */
    public function updateStock($quantity)
    {
        $this->stock += $quantity;
        return $this->save();
    }

    /**
     * Decrement stock when product is purchased
     */
    public function decrementStock($quantity = 1)
    {
        if ($this->stock >= $quantity) {
            $this->stock -= $quantity;
            return $this->save();
        }
        return false;
    }

    /**
     * Increment stock
     */
    public function incrementStock($quantity = 1)
    {
        $this->stock += $quantity;
        return $this->save();
    }

    /**
     * Check if product is low in stock
     */
    public function isLowStock($threshold = 10)
    {
        return $this->stock <= $threshold;
    }

    /**
     * Get products by category with pagination
     */
    public static function getProductsByCategory($category, $perPage = 12)
    {
        return self::byCategory($category)
                  ->inStock()
                  ->orderBy('name')
                  ->paginate($perPage);
    }

    /**
     * Search products by name or description
     */
    public static function search($searchTerm)
    {
        return self::where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->inStock()
                  ->orderBy('name')
                  ->get();
    }

    /**
     * Get featured products (you can customize the logic)
     */
    public static function getFeatured($limit = 8)
    {
        return self::inStock()
                  ->orderBy('created_at', 'desc')
                  ->limit($limit)
                  ->get();
    }

    /**
     * Get discounted products
     */
    public static function getDiscountedProducts($limit = 8)
    {
        return self::discounted()
                  ->inStock()
                  ->orderBy('created_at', 'desc')
                  ->limit($limit)
                  ->get();
    }
}