<?php

namespace App\Http\Controllers;

use App\Models\Beef;
use Illuminate\Http\Request;

class BeefController extends Controller
{
    /**
     * Show admin beef index page
     */
    public function index()
    {
        $beefs = Beef::all();

        // Create sample data if empty
        if ($beefs->count() === 0) {
            Beef::create([
                'name' => 'Ribeye',
                'price' => 10.0,
                'stock' => 5,
                'status' => 'active'
            ]);

            Beef::create([
                'name' => 'Chuck Steak',
                'price' => 12.5,
                'stock' => 8,
                'status' => 'active'
            ]);

            $beefs = Beef::all();
        }

        return view('admin.beef-crud', compact('beefs'));
    }

    /**
     * Show Add Beef form
     */
    public function create()
{
    return view('admin.adminaddnewitem', [
        'item' => null,
        'storeRoute' => 'admin.beef.store',
        'backRoute' => 'admin.beef-crud'
    ]);
}
    /**
     * Store new beef
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        Beef::create($request->all());

        return redirect()->route('admin.beef-crud')->with('success', 'Beef added successfully!');
    }

    /**
     * Show Edit Beef form
     */
public function edit($id)
{
    $item = Beef::findOrFail($id);
    return view('admin.edititem', [
        'item' => $item,
        'updateRoute' => 'admin.beef.update',
        'storeRoute' => 'admin.beef.store',
        'backRoute' => 'admin.beef-crud'
    ]);
}
public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'category' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
    ]);

    $item = Beef::findOrFail($id);
    $item->update($request->only(['name','category','price','stock']));

    return redirect()->route('admin.beef-crud')->with('success', 'Beef updated successfully!');
}

    /**
     * Delete beef
     */
    public function destroy($id)
{
    $beef = Beef::findOrFail($id);
    $beef->delete();

    return redirect()->route('admin.beef-crud')
                     ->with('success', 'Item deleted successfully!');
}

public function confirmDelete($id)
{
    $beef = Beef::findOrFail($id);
    return view('admin.delete-confirmation', [
        'item' => $beef,
        'type' => 'beef',
        'destroyRoute' => route('admin.beef.destroy', $id),
    ]);
}

}
