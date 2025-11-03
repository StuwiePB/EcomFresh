<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Beef;
use App\Models\CustomerStore;
use App\Models\DeleteHistoryTable;
use Illuminate\Support\Facades\DB;

class BeefController extends Controller
{
    /**
     * Show admin beefs index page - for web routes
     */
    public function index()
    {
        return $this->adminIndex();
    }

    /**
     * Show admin beefs index page
     */
    public function adminIndex()
    {
        $beefs = Beef::all();

        // If no beefs exist, create sample data
        if ($beefs->count() === 0) {
            Beef::create([
                'name' => 'Beef Steak',
                'category' => 'Meat',
                'price' => 8.50,
                'stock' => 20,
                'status' => 'active',
            ]);

            Beef::create([
                'name' => 'Ground Beef',
                'category' => 'Meat', 
                'price' => 6.50,
                'stock' => 25,
                'status' => 'active',
            ]);

            $beefs = Beef::all();
        }

        return view('admin.beef-crud', compact('beefs'));
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
            'storeRoute' => 'admin.beef.store',
            'backRoute' => 'admin.beef-crud',
        ]);
    }

    /**
     * Store new beef - NOW SYNC TO PRODUCTS TABLE
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        // 1. Save to admin beef table
        $beef = Beef::create($request->all());

        // 2. Sync to products table for customers
        $this->syncToProductsTable($request);

        return redirect()->route('admin.beef-crud')
                         ->with('success', 'Beef added successfully! Now visible to customers!');
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $item = Beef::findOrFail($id);
        $stores = CustomerStore::where('is_active', true)->get();

        return view('admin.edititem', [
            'item' => $item,
            'stores' => $stores,
            'updateRoute' => 'admin.beef.update',
            'backRoute' => 'admin.beef-crud',
        ]);
    }

    /**
     * Update beef - NOW SYNC TO PRODUCTS TABLE
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $beef = Beef::findOrFail($id);
        $originalName = $beef->name;
        
        $beef->update($request->only(['name','category','price','stock']));

        // Sync to products table
        $this->syncToProductsTable($request, $originalName);

        return redirect()->route('admin.beef-crud')->with('success', 'Beef updated successfully!');
    }

    /**
     * Delete beef and log to history
     */
    public function destroy($id)
    {
        $beef = Beef::findOrFail($id);

        // Log into delete history table
        DeleteHistoryTable::create([
            'name' => $beef->name,
            'category' => 'Beef',
            'quantity' => $beef->stock,
            'deleted_at' => now(),
        ]);

        // Also remove from products table (soft delete)
        DB::table('products')
            ->where('name', $beef->name)
            ->where('category', 'Beef')
            ->update(['deleted_at' => now()]);

        $beef->delete();

        return redirect()->route('admin.beef-crud')
                         ->with('success', 'Beef deleted and logged successfully!');
    }

    /**
     * Confirm delete page
     */
    public function confirmDelete($id)
    {
        $beef = Beef::findOrFail($id);
        $destroyRoute = route('admin.beef.destroy', ['id' => $beef->id]);

        return view('admin.delete-confirmation', [
            'item' => $beef,
            'destroyRoute' => $destroyRoute,
        ]);
    }

    /**
     * Sync beef product to products table
     */
    private function syncToProductsTable(Request $request, $originalName = null)
    {
        $productData = [
            'name' => $request->name,
            'category' => 'Beef', // Fixed category for customer side
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->name . ' - Fresh beef product',
            'image' => null,
            'is_discounted' => false,
            'discount_price' => null,
            'status' => 'active',
            'updated_at' => now(),
        ];

        if ($originalName) {
            // Update existing product
            DB::table('products')
                ->where('name', $originalName)
                ->where('category', 'Beef')
                ->update($productData);
        } else {
            // Insert new product
            $productData['created_at'] = now();
            DB::table('products')->insert($productData);
        }
    }
}