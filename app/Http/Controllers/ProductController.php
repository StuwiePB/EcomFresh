<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Show customer main page with categories
     */
    public function index()
    {
        $categories = Product::getCategories();
        return view('customer.main', compact('categories'));
    }

    /**
 * Show chicken products comparison page
 */
public function chickenProducts()
{
    $chickenProducts = [
        [
            'name' => 'Chicken Breast',
            'stores' => [
                [
                    'store_name' => 'Supa Save',
                    'price' => 3.50,
                    'distance' => '2.1 km',
                    'rating' => 4.2,
                    'is_favourite' => true
                ],
                [
                    'store_name' => 'Hua Ho',
                    'price' => 4.30,
                    'distance' => '1.8 km', 
                    'rating' => 4.4,
                    'is_favourite' => false
                ],
                [
                    'store_name' => 'Soon Lee',
                    'price' => 3.10,
                    'distance' => '3.2 km',
                    'rating' => 4.0,
                    'is_favourite' => false
                ]
            ]
        ],
        [
            'name' => 'Whole Chicken',
            'stores' => [
                [
                    'store_name' => 'Supa Save',
                    'price' => 5.50,
                    'distance' => '2.1 km',
                    'rating' => 4.2,
                    'is_favourite' => true
                ],
                [
                    'store_name' => 'Hua Ho', 
                    'price' => 6.80,
                    'distance' => '1.8 km',
                    'rating' => 4.4,
                    'is_favourite' => false
                ]
            ]
        ],
        [
            'name' => 'Chicken Thigh',
            'stores' => [
                [
                    'store_name' => 'Hua Ho',
                    'price' => 4.25,
                    'distance' => '1.8 km',
                    'rating' => 4.4,
                    'is_favourite' => false
                ],
                [
                    'store_name' => 'Supa Save',
                    'price' => 4.90,
                    'distance' => '2.1 km',
                    'rating' => 4.2,
                    'is_favourite' => true
                ]
            ]
        ]
    ];

    return view('customer.chicken-products', compact('chickenProducts'));
}

    /**
     * Show admin products index page
     */
public function adminIndex()
{
    $chickens = Product::all();
    
    // If no products exist, create sample data
    if ($chickens->count() === 0) {
        Product::create([
            'name' => 'Chicken Breast',
            'category' => 'Meat',
            'price' => 3.50,
            'stock' => 30,
            'status' => 'active'
        ]);
        
        Product::create([
            'name' => 'Whole Chicken',
            'category' => 'Meat',
            'price' => 5.50,
            'stock' => 30,
            'status' => 'active'
        ]);
        
        // Refresh the collection
        $chickens = Product::all();
    }
    
    return view('admin.chicken-crud', compact('chickens'));
}
public function adminChickenIndex()
{
    $chickens = Product::all(); // fetch all items
    return view('admin.chicken-crud', compact('chickens'));
}

    /**
     * Show Add Item form
     */
    public function create()
    {
        return view('admin.items.create');
    }

    public function edit($id)
{
    $item = Product::findOrFail($id); // fetch item by id
    return view('admin.edititem', compact('item'));
}

    /**
     * Handle saving a new item
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        Product::create($request->all());

        return redirect()->route('items.index')
                         ->with('success', 'Item added successfully!');
    }

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

    return redirect()->route('admin.chicken-crud')->with('success', 'Item updated successfully');
}
}