<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Product;
use App\Models\CustomerCategory;
use App\Models\CustomerProduct;

class ProductController extends Controller
{
    /**

     * CUSTOMER: Show main page with product categories
     */
    public function index()
    {
        // Prefer customer_categories/customer_products (unified customer tables)
        if (Schema::hasTable('customer_categories')) {
            $categories = CustomerCategory::where('is_active', true)
                ->withCount(['products' => function ($q) {
                    if (Schema::hasColumn('customer_products', 'status')) {
                        $q->where('status', 'active');
                    }
                }])
                ->get()
                ->map(function ($cat) {
                    return (object) [
                        'name' => $cat->name,
                        'slug' => $cat->slug ?? strtolower($cat->name),
                        'description' => $cat->description ?? 'Fresh ' . $cat->name . ' products',
                        'image' => $cat->image ?? $this->getCategoryImage($cat->name),
                        'icon' => $cat->icon ?? $this->getCategoryIcon($cat->name),
                        'products_count' => $cat->products_count ?? 0,
                        'is_active' => $cat->is_active ?? true,
                    ];
                });
        } else {
            $categoriesQuery = DB::table('products')
                ->select('category', DB::raw('COUNT(*) as products_count'));

            if (Schema::hasColumn('products', 'deleted_at')) {
                $categoriesQuery->whereNull('deleted_at');
            }

            if (Schema::hasColumn('products', 'status')) {
                $categoriesQuery->where('status', 'active');
            }

            $categories = $categoriesQuery->groupBy('category')
                ->get()
                ->map(function ($item) {
                    return (object)[
                        'name' => $item->category,
                        'slug' => strtolower($item->category),
                        'description' => 'Fresh ' . $item->category . ' products',
                        'image' => $this->getCategoryImage($item->category),
                        'icon' => $this->getCategoryIcon($item->category),
                        'products_count' => $item->products_count,
                        'is_active' => true,
                    ];
                });
        }

        return view('customer.main', compact('categories'));
    }

    /**
     * CUSTOMER: Show all active products in a given category
     */
    public function categoryProducts($category)
    {
        // Prefer customer_products when available
        if (Schema::hasTable('customer_categories') && Schema::hasTable('customer_products')) {
            // Try to find by slug first, fallback to name
            $cat = CustomerCategory::where('slug', $category)->orWhere('name', $category)->firstOrFail();

            $productsQuery = CustomerProduct::with('stores')
                ->where('category_id', $cat->id);

            if (Schema::hasColumn('customer_products', 'status')) {
                $productsQuery->where('status', 'active');
            }

            $products = $productsQuery->get();

            $formattedCategoryData = [
                'name'        => $cat->name,
                'description' => $cat->description ?? 'Fresh ' . $cat->name . ' products',
                'image'       => $cat->image ?? $this->getCategoryImage($cat->name),
                'products'    => $products->map(function ($product) {
                    return [
                        'name'        => $product->name,
                        'image'       => $product->image ?? '/images/default-product.jpg',
                        'description' => $product->description ?? $product->name . ' - Fresh product',
                        'stores'      => (function () use ($product) {
                            // Ensure we always compare only the two Soon Lee branches
                            $wanted = ['soon lee bandar seri begawan', 'soon lee gadong'];

                            // Build lookup from existing pivot stores
                            $lookup = [];
                            foreach ($product->stores as $store) {
                                $name = strtolower(trim(($store->store_name ?? $store->name ?? '')));
                                $lookup[$name] = [
                                    'store_name'    => $store->store_name ?? $store->name ?? 'Store',
                                    'price'         => $store->pivot->current_price ?? ($store->pivot->price ?? null),
                                    'originalPrice' => $store->pivot->original_price ?? null,
                                    'rating'        => $store->rating ?? 4.5,
                                    'store_hours'   => $store->store_hours ?? '9 AM - 9 PM',
                                    'is_favorite'   => false,
                                ];
                            }

                            // Return array in desired order; if a store is missing, provide placeholder
                            $result = [];
                            foreach ($wanted as $w) {
                                if (isset($lookup[$w])) {
                                    $result[] = $lookup[$w];
                                } else {
                                    // placeholder when store has no price for this product
                                    $label = ucwords($w);
                                    $result[] = [
                                        'store_name'    => $label,
                                        'price'         => null,
                                        'originalPrice' => null,
                                        'rating'        => 4.5,
                                        'store_hours'   => '9 AM - 9 PM',
                                        'is_favorite'   => false,
                                    ];
                                }
                            }

                            return $result;
                        })(),
                    ];
                })->toArray(),
            ];
        } else {
            $productsQuery = DB::table('products')
                ->where('category', $category);

            if (Schema::hasColumn('products', 'deleted_at')) {
                $productsQuery->whereNull('deleted_at');
            }

            if (Schema::hasColumn('products', 'status')) {
                $productsQuery->where('status', 'active');
            }

            $products = $productsQuery->get();

            $formattedCategoryData = [
                'name'        => $category,
                'description' => 'Fresh ' . $category . ' products',
                'image'       => $this->getCategoryImage($category),
                'products'    => $products->map(function ($product) {
                    return [
                        'name'        => $product->name,
                        'image'       => $product->image ?? '/images/default-product.jpg',
                        'description' => $product->description ?? $product->name . ' - Fresh product',
                        'stores'      => [[
                            'store_name'    => $product->store_name ?? 'Default Store',
                            'price'         => $product->price,
                            'originalPrice' => $product->is_discounted ? $product->discount_price : $product->price,
                            'rating'        => 4.5,
                            'store_hours'   => '9 AM - 9 PM',
                            'is_favorite'   => false,
                        ]],
                    ];
                })->toArray(),
            ];
        }

        return view('customer.category-products', [
            'categoryData' => $formattedCategoryData,
            'category'     => $category,
        ]);
    }

    /**
     * ADMIN: Show all products for the logged-in admin's store (legacy admin)
     */
    public function adminIndex()
    {
        $this->middleware('auth');
        $store = auth()->user()->store_name;

        $products = Product::where('store_name', $store)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.products.index', compact('products'));
    }

    /**
     * ADMIN: Store new product (auto-attach store_name)
     */
    public function store(Request $request)
    {
        $this->middleware('auth');

        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'category'    => 'required|string|max:100',
            'description' => 'nullable|string',
            'image'       => 'nullable|string',
            'status'      => 'nullable|string|in:active,inactive',
        ]);

        Product::create([
            'store_name'  => auth()->user()->store_name,
            'name'        => $request->name,
            'price'       => $request->price,
            'category'    => $request->category,
            'description' => $request->description,
            'image'       => $request->image ?? null,
            'status'      => $request->status ?? 'active',
        ]);

        return back()->with('success', 'Product created for your store.');
    }

    /**
     * ADMIN: Update product details (same store only)
     */
    public function update(Request $request, $id)
    {
        $this->middleware('auth');

        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'category'    => 'required|string|max:100',
            'description' => 'nullable|string',
            'image'       => 'nullable|string',
            'status'      => 'nullable|string|in:active,inactive',
        ]);

        $store = auth()->user()->store_name;

        $product = Product::where('id', $id)
            ->where('store_name', $store)
            ->firstOrFail();

        $product->update($request->only('name', 'price', 'category', 'description', 'image', 'status'));

        return back()->with('success', 'Product updated successfully!');
    }

    /**
     * ADMIN: Delete product (same store only)
     */
    public function destroy($id)
    {
        $this->middleware('auth');

        $store = auth()->user()->store_name;

        $product = Product::where('id', $id)
            ->where('store_name', $store)
            ->firstOrFail();

        $product->delete();

        return back()->with('success', 'Product deleted successfully!');
    }

    /**
     * Helper: Get default category image
     */
    private function getCategoryImage($category)
    {
        $images = [
            'Chicken'    => '/images/chicken-category.jpg',
            'Beef'       => '/images/beef-category.jpg',
            'Vegetables' => '/images/vegetables-category.jpg',
            'Meat'       => '/images/meat-category.jpg',
        ];

        return $images[$category] ?? '/images/default-category.jpg';
    }

    /**
     * Helper: Get default category icon
     */
    private function getCategoryIcon($category)
    {
        $icons = [
            'Chicken'    => 'fa-drumstick',
            'Beef'       => 'fa-cow',
            'Vegetables' => 'fa-carrot',
            'Meat'       => 'fa-drumstick-bite',
        ];

        return $icons[$category] ?? 'fa-box';
    }
}
