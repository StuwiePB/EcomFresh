<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use App\Models\Vegetable;
use App\Models\CustomerStore;
use App\Models\CustomerProduct;
use App\Models\CustomerCategory;
use App\Models\CustomerProductPrice;
use App\Models\CustomerFavorite;
use App\Models\DeleteHistoryTable;

class VegetableController extends Controller
{
    /**
     * Show admin vegetables index page - for web routes
     */
    public function index()
    {
        return $this->adminIndex();
    }

    /**
     * Show admin vegetables index page
     */
    public function adminIndex()
    {
        // Use customer-facing category/products like other controllers
        $vegCategory = CustomerCategory::whereIn('name', ['Vegetable','Vegetables'])->first();

        if (! $vegCategory) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Vegetable category not found.');
        }

        $vegetables = CustomerProduct::with(['stores'])->where('category_id', $vegCategory->id)->get();

        return view('admin.vegetable-crud', compact('vegetables'));
    }

    /**
     * Show Add Item form
     */
    public function create()
    {
        $stores = CustomerStore::where('is_active', true)->get();

        return view('admin.adminaddnewitem', [
            'item' => null,
            'stores' => $stores,
            'storeRoute' => 'admin.vegetable.store',
            'backRoute' => 'admin.vegetable-crud',
        ]);
    }

    /**
     * Store new vegetable - NOW SYNC TO PRODUCTS TABLE
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'prices' => 'required|array',
            'prices.*' => 'required|numeric|min:0',
        ]);

        $vegCategory = CustomerCategory::whereIn('name', ['Vegetable','Vegetables'])->firstOrFail();

        $baseSlug = Str::slug($request->name);
        $slug = $baseSlug;
        $counter = 1;
        while (CustomerProduct::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        $product = CustomerProduct::create([
            'category_id' => $vegCategory->id,
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'stock' => $request->stock,
            'image' => 'images/products/vegetable-default.jpg',
            'status' => 'active',
        ]);

        foreach ($request->prices as $storeId => $price) {
            CustomerProductPrice::create([
                'product_id' => $product->id,
                'store_id' => $storeId,
                'current_price' => $price,
                'in_stock' => $request->stock > 0,
                'stock' => $request->stock,
            ]);
        }

        $this->syncToProductsTableFromProduct($product);

        return redirect()->route('admin.vegetable-crud')
            ->with('success', 'Vegetable product added successfully!');
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $item = CustomerProduct::with('stores')->findOrFail($id);
        $stores = CustomerStore::where('is_active', true)->get();

        return view('admin.edititem', [
            'item' => $item,
            'stores' => $stores,
            'updateRoute' => 'admin.vegetable.update',
            'backRoute' => 'admin.vegetable-crud',
        ]);
    }

    /**
     * Update vegetable - NOW SYNC TO PRODUCTS TABLE
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'prices' => 'required|array',
            'prices.*' => 'required|numeric|min:0',
        ]);

        $product = CustomerProduct::findOrFail($id);

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'stock' => $request->stock,
            'status' => $request->stock > 0 ? 'active' : 'out_of_stock',
        ]);

        foreach ($request->prices as $storeId => $price) {
            CustomerProductPrice::updateOrCreate(
                ['product_id' => $product->id, 'store_id' => $storeId],
                ['current_price' => $price, 'in_stock' => $request->stock > 0, 'stock' => $request->stock]
            );
        }

        $this->syncToProductsTableFromProduct($product);

        return redirect()->route('admin.vegetable-crud')
            ->with('success', 'Vegetable product updated successfully!');
    }

    /**
     * Delete vegetable and log to history
     */
    public function destroy($id)
    {
        $product = CustomerProduct::findOrFail($id);

        DB::transaction(function () use ($product) {
            DeleteHistoryTable::create([
                'name' => $product->name,
                'category' => 'Vegetable',
                'quantity' => $product->stock,
                'deleted_at' => now(),
            ]);

            CustomerProductPrice::where('product_id', $product->id)->delete();
            CustomerFavorite::where('product_id', $product->id)->delete();
            $product->delete();
        });

        return redirect()->route('admin.vegetable-crud')
            ->with('success', 'Vegetable product deleted and logged successfully!');
    }

    /**
     * Confirm delete page
     */
    public function confirmDelete($id)
    {
        $product = CustomerProduct::findOrFail($id);
        $destroyRoute = route('admin.vegetable.destroy', ['id' => $product->id]);

        return view('admin.delete-confirmation', [
            'item' => $product,
            'type' => 'vegetable',
            'destroyRoute' => $destroyRoute,
        ]);
    }

    /**
     * Sync vegetable product to products table
     */
    private function syncToProductsTableFromProduct(CustomerProduct $product)
    {
        try {
            $bestPrice = CustomerProductPrice::where('product_id', $product->id)
                ->orderBy('current_price', 'asc')
                ->value('current_price');

            $productData = [
                'name' => $product->name,
                'category' => 'Vegetable',
                'price' => $bestPrice ?? 0,
                'stock' => $product->stock,
                'description' => $product->description ?? ($product->name . ' - Fresh vegetable product'),
                'image' => $product->image,
                'is_discounted' => false,
                'discount_price' => null,
                'status' => $product->status ?? 'active',
                'updated_at' => now(),
            ];

            $exists = DB::table('products')->where('name', $product->name)->where('category', 'Vegetable')->exists();
            if ($exists) {
                DB::table('products')->where('name', $product->name)->where('category', 'Vegetable')->update($productData);
            } else {
                $productData['created_at'] = now();
                DB::table('products')->insert($productData);
            }
        } catch (\Throwable $e) {
            // non-fatal
        }
    }
}