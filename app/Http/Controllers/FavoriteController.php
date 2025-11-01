<?php

namespace App\Http\Controllers;

use App\Models\CustomerFavorite;
use App\Models\CustomerProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Show favorites page with database favorites
     */
    public function index()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view your favorites.');
        }
        

        // Get user's favorites from database with product details
        $favorites = CustomerFavorite::with(['product.category', 'product.stores'])
            ->where('user_id', Auth::id())
            ->get()
            ->map(function($favorite) {
                $product = $favorite->product;
                return [
                    'name' => $product->name,
                    'category' => $product->category->name,
                    'description' => $product->description,
                    'image' => $product->image,
                    'stores' => $product->stores->map(function($store) {
                        return [
                            'store_name' => $store->name,
                            'price' => $store->pivot->current_price,
                            'originalPrice' => $store->pivot->original_price,
                            'rating' => $store->rating,
                            'store_hours' => $store->store_hours
                        ];
                    })->toArray()
                ];
            });

        return view('customer.favorites', compact('favorites'));
    }

    /**
     * Add product to favorites
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Please login to add favorites'
            ], 401);
        }

        $request->validate([
            'product_id' => 'required|exists:customer_products,id'
        ]);

        // Check if already favorited
        $existingFavorite = CustomerFavorite::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingFavorite) {
            return response()->json([
                'status' => 'exists',
                'message' => 'Product already in favorites'
            ]);
        }

        // Create new favorite
        $favorite = CustomerFavorite::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Added to favorites',
            'favorite' => $favorite
        ]);
    }

    /**
     * Remove product from favorites
     */
    public function destroy($productId)
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Please login to manage favorites'
            ], 401);
        }

        $favorite = CustomerFavorite::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Removed from favorites'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Favorite not found'
        ], 404);
    }

    /**
 * Get user's favorite status for products
 */
public function userStatus()
{
    if (!Auth::check()) {
        return response()->json([]);
    }

    $favorites = CustomerFavorite::where('user_id', Auth::id())
        ->get(['product_id'])
        ->map(function($fav) {
            return ['product_id' => $fav->product_id];
        });

    return response()->json($favorites);
}

    /**
     * Toggle favorite status
     */
    public function toggle(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Please login to toggle favorites'
            ], 401);
        }

        $request->validate([
            'product_id' => 'required|exists:customer_products,id'
        ]);

        $favorite = CustomerFavorite::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json([
                'status' => 'removed',
                'message' => 'Removed from favorites'
            ]);
        } else {
            CustomerFavorite::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id
            ]);
            return response()->json([
                'status' => 'added',
                'message' => 'Added to favorites'
            ]);
        }
    }
}