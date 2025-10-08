<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class EditItemController extends Controller
{
    // 🟢 Show Edit Form
    public function edit($id)
    {
        $item = Product::findOrFail($id);
        return view('admin.edititem', compact('item')); 
    }

    // 🟢 Update Item
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $item = Product::findOrFail($id);
        $item->update($validated);

        // ✅ Fix: safer redirect (fallback to previous page if route not found)
        if (route('items.index', [], false)) {
            return redirect()->route('items.index')->with('success', 'Item updated successfully');
        }

        return redirect()->back()->with('success', 'Item updated successfully');
    }

    // 🟢 (Optional) Show Add New Item Page for category reuse later
    public function create($category = null)
    {
        return view('admin.edititem', compact('category'));
    }

    // 🟢 (Optional) Store New Item
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        Product::create($validated);

        return redirect()->back()->with('success', "{$validated['category']} item added successfully!");
    }
}
