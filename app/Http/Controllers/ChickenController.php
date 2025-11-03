<?php

namespace App\Http\Controllers;
<?php

namespace App\Http\Controllers;

use App\Models\CustomerProduct;
use App\Models\CustomerCategory;
use App\Models\CustomerStore;
use App\Models\CustomerProductPrice;
use App\Models\DeleteHistoryTable;
use App\Models\CustomerFavorite;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ChickenController extends Controller
{
    /**
     * Display chicken products for admin (unified customer products)
     */
    public function adminIndex()
    {
        $chickenCategory = CustomerCategory::where('name', 'Chicken')->first();
        
        if (!$chickenCategory) {
            return redirect()->route('admin.dashboard')
                           ->with('error', 'Chicken category not found. Please run seeder.');
        }

       $chickenProducts = CustomerProduct::with(['category', 'stores'])
        ->where('category_id', $chickenCategory->id)
        ->get();

        return view('admin.chicken-crud', compact('chickenProducts'));
    
    /**
     * Show Add Chicken form
     */
    public function create()
    {
        $stores = CustomerStore::where('is_active', true)->get();
        
        return view('admin.adminaddnewitem', [
            'item' => null,
            'stores' => $stores,
            'storeRoute' => 'admin.chicken.store',
            'backRoute' => 'admin.chicken-crud'
        ]);
            'stock' => 'required|integer|min:0',
    /**
     * Store a new chicken product with store-specific prices
     */
   public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'stock' => 'required|integer|min:0',
        'prices' => 'required|array',
        'prices.*' => 'required|numeric|min:0'
    ]);

    $chickenCategory = CustomerCategory::where('name', 'Chicken')->firstOrFail();

    // Generate unique slug
    $baseSlug = \Illuminate\Support\Str::slug($request->name);
    $slug = $baseSlug;
    $counter = 1;

    // Check if slug exists and make it unique
    while (CustomerProduct::where('slug', $slug)->exists()) {
        $slug = $baseSlug . '-' . $counter;
        $counter++;
    }

    // Create the product
    $product = CustomerProduct::create([
        'category_id' => $chickenCategory->id,
        'name' => $request->name,
        'slug' => $slug,
        'description' => $request->description,
        'stock' => $request->stock,
        'image' => 'images/products/chicken-default.jpg', // Default image
        'status' => 'active'
    ]);

    // Create prices for each store
    foreach ($request->prices as $storeId => $price) {
        CustomerProductPrice::create([
            'product_id' => $product->id,
            'store_id' => $storeId,
            'current_price' => $price,
            'in_stock' => $request->stock > 0,
            'stock' => $request->stock
        ]);
    }

    return redirect()->route('admin.chicken-crud')
                     ->with('success', 'Chicken product added successfully!');
}

    /**
     * Show Edit form
     */
    public function edit($id)
    {
        $item = CustomerProduct::with('stores')->findOrFail($id);
        $stores = CustomerStore::where('is_active', true)->get();
        
        return view('admin.edititem', [
            'item' => $item,
            'stores' => $stores,
            'updateRoute' => 'admin.chicken.update',
            'backRoute' => 'admin.chicken-crud'
        ]);
    }

    /**
     * Update a chicken product
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'prices' => 'required|array',
            'prices.*' => 'required|numeric|min:0'
        ]);

        $product = CustomerProduct::findOrFail($id);
        
        // Update product
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'stock' => $request->stock,
            'status' => $request->stock > 0 ? 'active' : 'out_of_stock'
        ]);

        // Update prices for each store
        foreach ($request->prices as $storeId => $price) {
            CustomerProductPrice::updateOrCreate(
                [
                    'product_id' => $product->id,
                    'store_id' => $storeId
                ],
                [
                    'current_price' => $price,
                    'in_stock' => $request->stock > 0,
                    'stock' => $request->stock
                ]
            );
        }

        return redirect()->route('admin.chicken-crud')
                         ->with('success', 'Chicken product updated successfully!');
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'prices' => 'required|array',
            'prices.*' => 'required|numeric|min:0'
        ]);

<<<<<<< HEAD
        $chicken = Chicken::findOrFail($id);
        $originalName = $chicken->name;
        
        $chicken->update($request->only(['name','category','price','stock']));

        // Sync to products table
        $this->syncToProductsTable($request, $originalName);

        return redirect()->route('admin.chicken-crud')->with('success', 'Chicken updated successfully!');
=======
        $product = CustomerProduct::findOrFail($id);
        
        // Update product
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'stock' => $request->stock,
            'status' => $request->stock > 0 ? 'active' : 'out_of_stock'
        ]);

        // Update prices for each store
        foreach ($request->prices as $storeId => $price) {
            CustomerProductPrice::updateOrCreate(
                [
                    'product_id' => $product->id,
                    'store_id' => $storeId
                ],
                [
                    'current_price' => $price,
                    'in_stock' => $request->stock > 0,
                    'stock' => $request->stock
                ]
            );
        }

        return redirect()->route('admin.chicken-crud')
                         ->with('success', 'Chicken product updated successfully!');
>>>>>>> feature/homepage-design3
    }

    /**
     * Delete a chicken product and log into history
     */
    public function destroy($id)
    {
        $product = CustomerProduct::findOrFail($id);

        // Wrap deletion in a transaction to ensure related rows are removed first
        DB::transaction(function () use ($product) {
            // Log deletion into history table
            DeleteHistoryTable::create([
                'name' => $product->name,
                'category' => 'Chicken',
                'quantity' => $product->stock,
                'deleted_at' => now(),
            ]);

            // Delete related price records (foreign key constraint requires this)
            \App\Models\CustomerProductPrice::where('product_id', $product->id)->delete();

            // Delete any favorites referencing this product
            CustomerFavorite::where('product_id', $product->id)->delete();

            // Finally delete the product
            $product->delete();
        });

        return redirect()->route('admin.chicken-crud')
                         ->with('success', 'Chicken product deleted and logged successfully!');
    }

    /**
     * Confirm deletion page
     */
    public function confirmDelete($id)
    {
        $product = CustomerProduct::findOrFail($id);
        return view('admin.delete-confirmation', [
            'item' => $product,
            'type' => 'chicken',
            'destroyRoute' => route('admin.chicken.destroy', $id),
        ]);
    }
<<<<<<< HEAD

    /**
     * Sync chicken product to products table
     */
    private function syncToProductsTable(Request $request, $originalName = null)
    {
        $productData = [
            'name' => $request->name,
            'category' => 'Chicken', // Fixed category for customer side
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->name . ' - Fresh chicken product',
            'image' => null, // You can add image logic later
            'is_discounted' => false,
            'discount_price' => null,
            'status' => 'active',
            'updated_at' => now(),
        ];

        if ($originalName) {
            // Update existing product
            DB::table('products')
                ->where('name', $originalName)
                ->where('category', 'Chicken')
                ->update($productData);
        } else {
            // Insert new product
            $productData['created_at'] = now();
            DB::table('products')->insert($productData);
        }
=======
    
    /**
     * Admin index for chicken (if different from customer view)
     */
    public function confirmDelete($id)
    {
        $product = CustomerProduct::findOrFail($id);
        return view('admin.delete-confirmation', [
            'item' => $product,
            'type' => 'chicken',
            'destroyRoute' => route('admin.chicken.destroy', $id),
        ]);
    }
    
    /**
     * Admin index for chicken (if different from customer view)
     */
    public function index()
    {
        $chickenCategory = CustomerCategory::where('name', 'Chicken')->first();
        
        if (!$chickenCategory) {
            return redirect()->route('admin.dashboard')
                           ->with('error', 'Chicken category not found.');
        }

        $chickenProducts = CustomerProduct::where('category_id', $chickenCategory->id)->get();

        return view('admin.chicken-crud', compact('chickenProducts'));
    }