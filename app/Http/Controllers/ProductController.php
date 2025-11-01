<?php

namespace App\Http\Controllers;

use App\Models\CustomerCategory;
use App\Models\CustomerProduct;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Show customer main page with categories
     */
    public function index()
    {
        // Get categories with products count
        $categories = CustomerCategory::where('is_active', true)
            ->withCount('products')
            ->get();
        
        return view('customer.main', compact('categories'));
    }

    /**
     * Show products for a specific category
     */
    public function categoryProducts($category)
    {
        // Get category with products and their stores/prices
        $categoryData = CustomerCategory::where('slug', $category)
            ->with(['products' => function($query) {
                $query->where('is_active', true)
                      ->with(['stores' => function($q) {
                          $q->where('is_active', true);
                      }]);
            }])
            ->firstOrFail();

        // Transform data for your existing blade template
        $formattedCategoryData = [
            'name' => $categoryData->name,
            'description' => $categoryData->description,
            'image' => $categoryData->image,
            'products' => $categoryData->products->map(function($product) {
                return [
                    'name' => $product->name,
                    'image' => $product->image,
                    'description' => $product->description,
                    'stores' => $product->stores->map(function($store) {
                        return [
                            'store_name' => $store->name,
                            'price' => $store->pivot->current_price,
                            'originalPrice' => $store->pivot->original_price,
                            'rating' => $store->rating,
                            'store_hours' => $store->store_hours,
                            'is_favorite' => false
                        ];
                    })->toArray()
                ];
            })->toArray()
        ];

        return view('customer.category-products', [
            'categoryData' => $formattedCategoryData,
            'category' => $category
        ]);
    }
}