<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chicken;
use App\Models\DeleteHistoryTable;
use Illuminate\Support\Facades\DB;

class ChickenController extends Controller
{
    /**
     * Show admin chickens index page
     */
    public function adminIndex()
    {
        $chickens = Chicken::all();

        // If no chickens exist, create sample data
        if ($chickens->count() === 0) {
            Chicken::create([
                'name' => 'Chicken Breast',
                'category' => 'Meat',
                'price' => 3.50,
                'stock' => 30,
                'status' => 'active',
            ]);

            Chicken::create([
                'name' => 'Whole Chicken',
                'category' => 'Meat', 
                'price' => 5.50,
                'stock' => 30,
                'status' => 'active',
            ]);

            $chickens = Chicken::all();
        }

        return view('admin.chicken-crud', compact('chickens'));
    }

    /**
     * Show Add Item form
     */
    public function create()
    {
        return view('admin.adminaddnewitem');
    }

    /**
     * Store new chicken - NOW SYNC TO PRODUCTS TABLE
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        // 1. Save to admin chicken table
        $chicken = Chicken::create($request->all());

        // 2. Sync to products table for customers
        $this->syncToProductsTable($request);

        return redirect()->route('admin.chicken-crud')
                         ->with('success', 'Chicken added successfully! Now visible to customers!');
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $item = Chicken::findOrFail($id);
        return view('admin.edititem', [
            'item' => $item,
            'updateRoute' => 'admin.chicken.update',
            'backRoute' => 'admin.chicken-crud',
        ]);
    }

    /**
     * Update chicken - NOW SYNC TO PRODUCTS TABLE
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $chicken = Chicken::findOrFail($id);
        $originalName = $chicken->name;
        
        $chicken->update($request->only(['name','category','price','stock']));

        // Sync to products table
        $this->syncToProductsTable($request, $originalName);

        return redirect()->route('admin.chicken-crud')->with('success', 'Chicken updated successfully!');
    }

    /**
     * Delete chicken and log to history
     */
    public function destroy($id)
    {
        $chicken = Chicken::findOrFail($id);

        // Log into delete history table
        DeleteHistoryTable::create([
            'name' => $chicken->name,
            'category' => 'Chicken',
            'quantity' => $chicken->stock,
            'deleted_at' => now(),
        ]);

        // Also remove from products table (soft delete)
        DB::table('products')
            ->where('name', $chicken->name)
            ->where('category', 'Chicken')
            ->update(['deleted_at' => now()]);

        $chicken->delete();

        return redirect()->route('admin.chicken-crud')
                         ->with('success', 'Chicken deleted and logged successfully!');
    }

    /**
     * Confirm delete page
     */
    public function confirmDelete($id)
    {
        $chicken = Chicken::findOrFail($id);
        $destroyRoute = route('admin.chicken.destroy', ['id' => $chicken->id]);

        return view('admin.delete-confirmation', [
            'item' => $chicken,
            'destroyRoute' => $destroyRoute,
        ]);
    }

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
    }
}