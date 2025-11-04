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
        $chickenProducts = DB::table('chicken')->whereNull('deleted_at')->get();
        return view('admin.chicken-crud', compact('chickenProducts'));
    }

    /**
     * Show Add Item form
     */
    public function create()
    {
        return view('admin.adminaddnewitem');
    }

    /**
     * Store new chicken
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        Chicken::create($request->all());

        return redirect()->route('admin.chicken-crud')
                         ->with('success', 'Chicken added successfully!');
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
     * Update chicken
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
        $chicken->update($request->only(['name','category','price','stock']));

        return redirect()->route('admin.chicken-crud')
                         ->with('success', 'Chicken updated successfully!');
    }

    /**
     * Delete chicken and log to history
     */
    public function destroy($id)
    {
        $chicken = Chicken::findOrFail($id);

        DeleteHistoryTable::create([
            'name' => $chicken->name,
            'category' => 'Chicken',
            'quantity' => $chicken->stock,
            'deleted_at' => now(),
        ]);

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
}
