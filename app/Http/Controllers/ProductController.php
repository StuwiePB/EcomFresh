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
 * Show products for a specific category
 */
public function categoryProducts($category)
{
    $categoryData = $this->getCategoryData($category);
    
    if (!$categoryData) {
        return redirect('/todaysprice');
    }

    return view('customer.category-products', compact('categoryData', 'category'));
}

/**
 * Get products data for each category
 */
private function getCategoryData($categoryName)
{
    $categories = [
        'chicken' => [
            'name' => 'Chicken',
            'description' => 'Fresh poultry products at the best prices',
            'image' => 'images/categories/chicken.jpg',
            'products' => [
                [
                    'name' => 'Chicken Breast',
                    'image' => 'images/products/chicken-breast.jpg',
                    'stores' => [
                        [
                            'store_name' => 'Supa Save',
                            'price' => 3.60,
                            'distance' => '2.1 km',
                            'rating' => 4.2,
                            'is_favourite' => true,
                            'store_hours' => '8AM-9PM'
                        ],
                        [
                            'store_name' => 'Hua Ho',
                            'price' => 4.10,
                            'distance' => '1.8 km', 
                            'rating' => 4.4,
                            'is_favourite' => false,
                            'store_hours' => '7:30AM-10PM'
                        ],
                        [
                            'store_name' => 'Soon Lee',
                            'price' => 3.10,
                            'distance' => '3.2 km',
                            'rating' => 4.0,
                            'is_favourite' => false,
                            'store_hours' => '9AM-8PM'
                        ]
                    ]
                ],
                [
                    'name' => 'Whole Chicken',
                    'image' => 'images/products/whole-chicken.jpg',
                    'stores' => [
                        [
                            'store_name' => 'Supa Save',
                            'price' => 5.50,
                            'distance' => '2.1 km',
                            'rating' => 4.2,
                            'is_favourite' => true,
                            'store_hours' => '8AM-9PM'
                        ],
                        [
                            'store_name' => 'Hua Ho', 
                            'price' => 6.30,
                            'distance' => '1.8 km',
                            'rating' => 4.4,
                            'is_favourite' => false,
                            'store_hours' => '7:30AM-10PM'
                        ]
                    ]
                ],
                [
                    'name' => 'Chicken Thigh',
                    'image' => 'images/products/chicken-thigh.jpg',
                    'stores' => [
                        [
                            'store_name' => 'Hua Ho',
                            'price' => 5.00,
                            'distance' => '1.8 km',
                            'rating' => 4.4,
                            'is_favourite' => false,
                            'store_hours' => '7:30AM-10PM'
                        ],
                        [
                            'store_name' => 'Supa Save',
                            'price' => 4.10,
                            'distance' => '2.1 km',
                            'rating' => 4.2,
                            'is_favourite' => true,
                            'store_hours' => '8AM-9PM'
                        ]
                    ]
                ]
            ]
        ],
        'beef' => [
            'name' => 'Beef',
            'description' => 'Quality beef selections across stores',
            'image' => 'images/categories/beef.jpg',
            'products' => [
                [
                    'name' => 'Chuck steak',
                    'image' => 'images/products/beef-sirloin.jpg',
                    'stores' => [
                        [
                            'store_name' => 'Hua Ho',
                            'price' => 13.50,
                            'distance' => '1.8 km',
                            'rating' => 4.4,
                            'is_favourite' => true,
                            'store_hours' => '7:30AM-10PM'
                        ],
                        [
                            'store_name' => 'Supa Save',
                            'price' => 12.00,
                            'distance' => '2.1 km',
                            'rating' => 4.2,
                            'is_favourite' => false,
                            'store_hours' => '8AM-9PM'
                        ]
                    ]
                ],
                [
                    'name' => 'Ribeye steak',
                    'image' => 'images/products/ground-beef.jpg',
                    'stores' => [
                        [
                            'store_name' => 'Supa Save',
                            'price' => 10.00,
                            'distance' => '2.1 km',
                            'rating' => 4.2,
                            'is_favourite' => true,
                            'store_hours' => '8AM-9PM'
                        ],
                        [
                            'store_name' => 'Soon Lee',
                            'price' => 8.50,
                            'distance' => '3.2 km',
                            'rating' => 4.0,
                            'is_favourite' => false,
                            'store_hours' => '9AM-8PM'
                        ]
                    ]
                ],
                [
                    'name' => 'Striploin',
                    'image' => 'images/products/beef-ribeye.jpg',
                    'stores' => [
                        [
                            'store_name' => 'Hua Ho',
                            'price' => 22.00,
                            'distance' => '1.8 km',
                            'rating' => 4.4,
                            'is_favourite' => false,
                            'store_hours' => '7:30AM-10PM'
                        ],
                        [
                            'store_name' => 'Supa Save',
                            'price' => 19.50,
                            'distance' => '2.1 km',
                            'rating' => 4.2,
                            'is_favourite' => true,
                            'store_hours' => '8AM-9PM'
                        ]
                    ]
                ]
            ]
        ],
        'vegetables' => [
            'name' => 'Vegetables',
            'description' => 'Fresh vegetables from local markets',
            'image' => 'images/categories/vegetables.jpg',
            'products' => [
                [
                    'name' => 'Carrots',
                    'image' => 'images/products/tomatoes.jpg',
                    'stores' => [
                        [
                            'store_name' => 'Supa Save',
                            'price' => 2.50,
                            'distance' => '2.1 km',
                            'rating' => 4.2,
                            'is_favourite' => true,
                            'store_hours' => '8AM-9PM'
                        ],
                        [
                            'store_name' => 'Hua Ho',
                            'price' => 3,10,
                            'distance' => '1.8 km',
                            'rating' => 4.4,
                            'is_favourite' => false,
                            'store_hours' => '7:30AM-10PM'
                        ]
                    ]
                ],
                [
                    'name' => 'Cabbages',
                    'image' => 'images/products/potatoes.jpg',
                    'stores' => [
                        [
                            'store_name' => 'Soon Lee',
                            'price' => 1.80,
                            'distance' => '3.2 km',
                            'rating' => 4.0,
                            'is_favourite' => false,
                            'store_hours' => '9AM-8PM'
                        ],
                        [
                            'store_name' => 'Supa Save',
                            'price' => 2.50,
                            'distance' => '2.1 km',
                            'rating' => 4.2,
                            'is_favourite' => true,
                            'store_hours' => '8AM-9PM'
                        ]
                    ]
                ],
                [
                    'name' => 'Beansprouts',
                    'image' => 'images/products/carrots.jpg',
                    'stores' => [
                        [
                            'store_name' => 'Hua Ho',
                            'price' => 1.90,
                            'distance' => '1.8 km',
                            'rating' => 4.4,
                            'is_favourite' => true,
                            'store_hours' => '7:30AM-10PM'
                        ],
                        [
                            'store_name' => 'Supa Save',
                            'price' => 2.40,
                            'distance' => '2.1 km',
                            'rating' => 4.2,
                            'is_favourite' => false,
                            'store_hours' => '8AM-9PM'
                        ]
                    ]
                ]
            ]
        ]
        
    ];

    return $categories[strtolower($categoryName)] ?? null;
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
    public function destroy($id)
{
    $item = Product::findOrFail($id);
    $item->delete();

    return redirect()->back()->with('success', 'Item deleted successfully!');
}
}