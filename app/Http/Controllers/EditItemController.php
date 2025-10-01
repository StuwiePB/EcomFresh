<?php

namespace App\Http\Controllers;

use App\Models\Product; // Or Item model if you named it Item
use Illuminate\Http\Request;

class EditItemController extends Controller
{
    // Show edit form
    public function edit($id)
    {
        $item = Product::findOrFail($id);
    return view('admin.edititem', compact('item')); 
    }

    // Update item
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $item = Product::findOrFail($id);
        $item->update([
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return redirect()->route('items.index')->with('success', 'Item updated successfully');
    }
}
