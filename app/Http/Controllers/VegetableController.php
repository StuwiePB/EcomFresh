<?php

namespace App\Http\Controllers;

use App\Models\Vegetable;
use Illuminate\Http\Request;

class VegetableController extends Controller
{
    // List all vegetables
    public function index()
    {
        $vegetables = Vegetable::all();

        // If no vegetables exist, create sample data
        if ($vegetables->count() === 0) {
            Vegetable::create(['name' => 'Carrot', 'category' => 'Root', 'price' => 2.50, 'stock' => 20]);
            Vegetable::create(['name' => 'Cabbage', 'category' => 'Leafy', 'price' => 1.80, 'stock' => 15]);
            $vegetables = Vegetable::all();
        }

        return view('admin.vegetable-crud', compact('vegetables'));
    }

    // Show form to add new vegetable
    public function create()
{
    return view('admin.adminaddnewitem', [
        'item' => null,
        'storeRoute' => 'admin.vegetable.store',
        'backRoute' => 'admin.vegetable-crud'
    ]);
}

    // Store new vegetable
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        Vegetable::create($request->all());

        return redirect()->route('admin.vegetable-crud')->with('success', 'Vegetable added successfully!');
    }

    // Show edit form (shared blade)
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

    // Update vegetable
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $vegetable = Vegetable::findOrFail($id);
        $vegetable->update($request->all());

        return redirect()->route('admin.vegetable-crud')->with('success', 'Vegetable updated successfully!');
    }

    // Delete vegetable
   public function destroy($id)
{
    $vegetable = Vegetable::findOrFail($id);
    $vegetable->delete();

    return redirect()->route('admin.vegetable-crud')
                     ->with('success', 'Item deleted successfully!');
}

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
