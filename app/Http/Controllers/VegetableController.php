<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vegetable;
use App\Models\DeleteHistoryTable;
use Illuminate\Support\Facades\DB;

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
        $vegetables = Vegetable::all();

        // If no vegetables exist, create sample data
        if ($vegetables->count() === 0) {
            Vegetable::create([
                'name' => 'Carrots',
                'category' => 'Vegetables',
                'price' => 2.50,
                'stock' => 40,
                'status' => 'active',
            ]);

            Vegetable::create([
                'name' => 'Broccoli',
                'category' => 'Vegetables', 
                'price' => 3.00,
                'stock' => 35,
                'status' => 'active',
            ]);

            $vegetables = Vegetable::all();
        }

        return view('admin.vegetable-crud', compact('vegetables'));
    }

    /**
     * Show Add Item form
     */
    public function create()
    {
        return view('admin.adminaddnewitem');
    }

    /**
     * Store new vegetable - NOW SYNC TO PRODUCTS TABLE
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        // 1. Save to admin vegetable table
        $vegetable = Vegetable::create($request->all());

        // 2. Sync to products table for customers
        $this->syncToProductsTable($request);

        return redirect()->route('admin.vegetable-crud')
                         ->with('success', 'Vegetable added successfully! Now visible to customers!');
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $item = Vegetable::findOrFail($id);
        return view('admin.edititem', [
            'item' => $item,
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
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $vegetable = Vegetable::findOrFail($id);
        $originalName = $vegetable->name;
        
        $vegetable->update($request->only(['name','category','price','stock']));

        // Sync to products table
        $this->syncToProductsTable($request, $originalName);

        return redirect()->route('admin.vegetable-crud')->with('success', 'Vegetable updated successfully!');
    }

    /**
     * Delete vegetable and log to history
     */
    public function destroy($id)
    {
        $vegetable = Vegetable::findOrFail($id);

        // Log into delete history table
        DeleteHistoryTable::create([
            'name' => $vegetable->name,
            'category' => 'Vegetables',
            'quantity' => $vegetable->stock,
            'deleted_at' => now(),
        ]);

        // Also remove from products table (soft delete)
        DB::table('products')
            ->where('name', $vegetable->name)
            ->where('category', 'Vegetables')
            ->update(['deleted_at' => now()]);

        $vegetable->delete();

        return redirect()->route('admin.vegetable-crud')
                         ->with('success', 'Vegetable deleted and logged successfully!');
    }

    /**
     * Confirm delete page
     */
    public function confirmDelete($id)
    {
        $vegetable = Vegetable::findOrFail($id);
        $destroyRoute = route('admin.vegetable.destroy', ['id' => $vegetable->id]);

        return view('admin.delete-confirmation', [
            'item' => $vegetable,
            'destroyRoute' => $destroyRoute,
        ]);
    }

    /**
     * Sync vegetable product to products table
     */
    private function syncToProductsTable(Request $request, $originalName = null)
    {
        $productData = [
            'name' => $request->name,
            'category' => 'Vegetables', // Fixed category for customer side
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->name . ' - Fresh vegetable product',
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
                ->where('category', 'Vegetables')
                ->update($productData);
        } else {
            // Insert new product
            $productData['created_at'] = now();
            DB::table('products')->insert($productData);
        }
    }
}