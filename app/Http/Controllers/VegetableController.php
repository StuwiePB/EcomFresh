<?php

namespace App\Http\Controllers;

use App\Models\Vegetable;
use App\Models\DeleteHistoryTable;
use Illuminate\Http\Request;

class VegetableController extends Controller
{
    /**
     * Display all vegetables (Admin)
     */
    public function index()
    {
        $vegetables = Vegetable::all();

        // Create sample data if none exist
        if ($vegetables->count() === 0) {
            Vegetable::create(['name' => 'Carrot', 'category' => 'Root', 'price' => 2.50, 'stock' => 20, 'status' => 'active']);
            Vegetable::create(['name' => 'Cabbage', 'category' => 'Leafy', 'price' => 1.80, 'stock' => 15, 'status' => 'active']);
            $vegetables = Vegetable::all();
        }

        return view('admin.vegetable-crud', compact('vegetables'));
    }

    /**
     * Show Add Vegetable form
     */
    public function create()
    {
        return view('admin.adminaddnewitem', [
            'item' => null,
            'storeRoute' => 'admin.vegetable.store',
            'backRoute' => 'admin.vegetable-crud'
        ]);
    }

    /**
     * Store a new vegetable
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        Vegetable::create($request->all());

        return redirect()->route('admin.vegetable-crud')
                         ->with('success', 'Vegetable added successfully!');
    }

    /**
     * Show Edit form
     */
    public function edit($id)
    {
        $item = Vegetable::findOrFail($id);
        return view('admin.edititem', [
            'item' => $item,
            'updateRoute' => 'admin.vegetable.update',
            'storeRoute' => 'admin.vegetable.store',
            'backRoute' => 'admin.vegetable-crud'
        ]);
    }

    /**
     * Update a vegetable
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
        $vegetable->update($request->only(['name', 'category', 'price', 'stock']));

        return redirect()->route('admin.vegetable-crud')->with('success', 'Vegetable updated successfully!');
    }

    /**
     * Delete a vegetable and log into history
     */
    public function destroy($id)
    {
        $vegetable = Vegetable::findOrFail($id);

        // Log deletion into history table
        DeleteHistoryTable::create([
            'name' => $vegetable->name,
            'category' => 'Vegetable',
            'quantity' => $vegetable->stock,
            'deleted_at' => now(),
        ]);

        $vegetable->delete();

        return redirect()->route('admin.vegetable-crud')
                         ->with('success', 'Vegetable deleted and logged successfully!');
    }

    /**
     * Confirm deletion page
     */
    public function confirmDelete($id)
    {
        $vegetable = Vegetable::findOrFail($id);
        return view('admin.delete-confirmation', [
            'item' => $vegetable,
            'type' => 'vegetable',
            'destroyRoute' => route('admin.vegetable.destroy', $id),
        ]);
    }
}
