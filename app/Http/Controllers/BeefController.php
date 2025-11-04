<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerStore;
use App\Models\CustomerProduct;
use App\Models\CustomerCategory;
use App\Models\CustomerProductPrice;
use App\Models\CustomerFavorite;
use App\Models\DeleteHistoryTable;

class BeefController extends Controller
{
    public function index() { return $this->adminIndex(); }

    public function adminIndex()
    {
        $beefCategory = CustomerCategory::where('name', 'Beef')->first();
        if (!$beefCategory) {
            return redirect()->route('admin.dashboard')
                             ->with('error', 'Beef category not found.');
        }

        $beefs = CustomerProduct::with('stores')
                    ->where('category_id', $beefCategory->id)
                    ->get();

        return view('admin.beef-crud', compact('beefs'));
    }

    public function create()
    {
        $stores = CustomerStore::where('is_active', true)->get();

        return view('admin.adminaddnewitem', [
            'item' => null,
            'stores' => $stores,
            'storeRoute' => 'admin.beef.store',
            'backRoute' => 'admin.beef-crud',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'prices' => 'required|array',
            'prices.*' => 'required|numeric|min:0',
        ]);

        $beefCategory = CustomerCategory::where('name', 'Beef')->firstOrFail();

        $slug = $this->generateUniqueSlug($request->name);

        $product = CustomerProduct::create([
            'category_id' => $beefCategory->id,
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'stock' => $request->stock,
            'image' => 'images/products/beef-default.jpg',
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

        return redirect()->route('admin.beef-crud')
                         ->with('success', 'Beef product added successfully!');
    }

    public function edit($id)
    {
        $item = CustomerProduct::with('stores')->findOrFail($id);
        $stores = CustomerStore::where('is_active', true)->get();

        return view('admin.edititem', [
            'item' => $item,
            'stores' => $stores,
            'updateRoute' => 'admin.beef.update',
            'backRoute' => 'admin.beef-crud',
        ]);
    }

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

        return redirect()->route('admin.beef-crud')
                         ->with('success', 'Beef product updated successfully!');
    }

    public function destroy($id)
    {
        $product = CustomerProduct::findOrFail($id);

        DB::transaction(function () use ($product) {
            DeleteHistoryTable::create([
                'name' => $product->name,
                'category' => 'Beef',
                'quantity' => $product->stock,
                'deleted_at' => now(),
            ]);

            CustomerProductPrice::where('product_id', $product->id)->delete();
            CustomerFavorite::where('product_id', $product->id)->delete();
            $product->delete();
        });

        return redirect()->route('admin.beef-crud')
                         ->with('success', 'Beef product deleted and logged successfully!');
    }

    public function confirmDelete($id)
    {
        $product = CustomerProduct::findOrFail($id);
        $destroyRoute = route('admin.beef.destroy', $product->id);

        return view('admin.delete-confirmation', [
            'item' => $product,
            'type' => 'beef',
            'destroyRoute' => $destroyRoute,
        ]);
    }

    private function syncToProductsTableFromProduct(CustomerProduct $product)
    {
        try {
            $bestPrice = CustomerProductPrice::where('product_id', $product->id)
                ->orderBy('current_price', 'asc')
                ->value('current_price');

            $productData = [
                'name' => $product->name,
                'category' => 'Beef',
                'price' => $bestPrice ?? 0,
                'stock' => $product->stock,
                'description' => $product->description ?? ($product->name . ' - Fresh beef product'),
                'image' => $product->image,
                'is_discounted' => false,
                'discount_price' => null,
                'status' => $product->status ?? 'active',
                'updated_at' => now(),
            ];

            $exists = DB::table('products')->where('name', $product->name)->where('category', 'Beef')->exists();
            if ($exists) {
                DB::table('products')->where('name', $product->name)->where('category', 'Beef')->update($productData);
            } else {
                $productData['created_at'] = now();
                DB::table('products')->insert($productData);
            }
        } catch (\Throwable $e) {
            // non-fatal
        }
    }

    private function generateUniqueSlug($name)
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;
        while (CustomerProduct::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }
        return $slug;
    }
}
