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
        // Fetch categories dynamically if you have a category model/table
        // For now, using hardcoded list (fixed typos)
        $categories = [
            [
                'name' => 'Chicken',
                'description' => 'Fresh poultry products at the best prices',
                'image' => 'images/categories/chicken.jpg'
            ],
            [
                'name' => 'Beef',
                'description' => 'Quality beef selections across stores',
                'image' => 'images/categories/beef.jpg'
            ],
            [
                'name' => 'Vegetables',
                'description' => 'Fresh vegetables from local markets',
                'image' => 'images/categories/vegetables.jpg'
            ]
        ];

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
     * Hardcoded products data for each category (fixed price typo: dot instead of comma)
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
                        ['store_name'=>'Supa Save','price'=>3.60,'distance'=>'2.1 km','rating'=>4.2,'is_favorite'=>false,'store_hours'=>'8AM-9PM'], // ← Changed to false
                        ['store_name'=>'Hua Ho','price'=>4.10,'distance'=>'1.8 km','rating'=>4.4,'is_favorite'=>false,'store_hours'=>'7:30AM-10PM'],
                        ['store_name'=>'Soon Lee','price'=>3.30,'distance'=>'3.2 km','rating'=>4.0,'is_favorite'=>false,'store_hours'=>'9AM-8PM']
                    ]
                ],
                [
                    'name' => 'Whole Chicken',
                    'image' => 'images/products/whole-chicken.jpg',
                    'stores' => [
                        ['store_name'=>'Supa Save','price'=>5.50,'distance'=>'2.1 km','rating'=>4.2,'is_favorite'=>false,'store_hours'=>'8AM-9PM'], // ← Changed to false
                        ['store_name'=>'Hua Ho','price'=>6.30,'distance'=>'1.8 km','rating'=>4.4,'is_favorite'=>false,'store_hours'=>'7:30AM-10PM']
                    ]
                ],
                [
                    'name' => 'Chicken Thigh',
                    'image' => 'images/products/chicken-thigh.jpg',
                    'stores' => [
                        ['store_name'=>'Hua Ho','price'=>4.25,'distance'=>'1.8 km','rating'=>4.4,'is_favorite'=>false,'store_hours'=>'7:30AM-10PM'],
                        ['store_name'=>'Supa Save','price'=>4.10,'distance'=>'2.1 km','rating'=>4.2,'is_favorite'=>false,'store_hours'=>'8AM-9PM'], // ← Changed to false
                        ['store_name'=>'Soon Lee','price'=>3.95,'distance'=>'3.2 km','rating'=>4.0,'is_favorite'=>false,'store_hours'=>'9AM-8PM']
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
                    'name' => 'Chuck Steak',
                    'image' => 'images/products/chuck-steak.jpg',
                    'stores' => [
                        ['store_name'=>'Hua Ho','price'=>13.50,'distance'=>'1.8 km','rating'=>4.4,'is_favorite'=>false,'store_hours'=>'7:30AM-10PM'], // ← Changed to false
                        ['store_name'=>'Supa Save','price'=>12.00,'distance'=>'2.1 km','rating'=>4.2,'is_favorite'=>false,'store_hours'=>'8AM-9PM'],
                        ['store_name'=>'Soon Lee','price'=>11.80,'distance'=>'3.2 km','rating'=>4.0,'is_favorite'=>false,'store_hours'=>'9AM-8PM']
                    ]
                ],
                [
                    'name' => 'Ribeye Steak',
                    'image' => 'images/products/ribeye-steak.jpg',
                    'stores' => [
                        ['store_name'=>'Hua Ho','price'=>18.75,'distance'=>'1.8 km','rating'=>4.4,'is_favorite'=>false,'store_hours'=>'7:30AM-10PM'],
                        ['store_name'=>'Supa Save','price'=>17.90,'distance'=>'2.1 km','rating'=>4.2,'is_favorite'=>false,'store_hours'=>'8AM-9PM'] // ← Changed to false
                    ]
                ],
                [
                    'name' => 'Striploin Steak',
                    'image' => 'images/products/striploin-steak.jpg',
                    'stores' => [
                        ['store_name'=>'Supa Save','price'=>16.50,'distance'=>'2.1 km','rating'=>4.2,'is_favorite'=>false,'store_hours'=>'8AM-9PM'], // ← Changed to false
                        ['store_name'=>'Hua Ho','price'=>17.20,'distance'=>'1.8 km','rating'=>4.4,'is_favorite'=>false,'store_hours'=>'7:30AM-10PM']
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
                    'image' => 'images/products/carrots.jpg',
                    'stores' => [
                        ['store_name'=>'Supa Save','price'=>2.50,'distance'=>'2.1 km','rating'=>4.2,'is_favorite'=>false,'store_hours'=>'8AM-9PM'], // ← Changed to false
                        ['store_name'=>'Hua Ho','price'=>3.10,'distance'=>'1.8 km','rating'=>4.4,'is_favorite'=>false,'store_hours'=>'7:30AM-10PM'],
                        ['store_name'=>'Soon Lee','price'=>2.30,'distance'=>'3.2 km','rating'=>4.0,'is_favorite'=>false,'store_hours'=>'9AM-8PM']
                    ]
                ],
                [
                    'name' => 'Cabbages',
                    'image' => 'images/products/cabbages.jpg',
                    'stores' => [
                        ['store_name'=>'Hua Ho','price'=>2.80,'distance'=>'1.8 km','rating'=>4.4,'is_favorite'=>false,'store_hours'=>'7:30AM-10PM'], // ← Changed to false
                        ['store_name'=>'Supa Save','price'=>2.60,'distance'=>'2.1 km','rating'=>4.2,'is_favorite'=>false,'store_hours'=>'8AM-9PM']
                    ]
                ],
                [
                    'name' => 'Bean Sprouts',
                    'image' => 'images/products/beansprouts.jpg',
                    'stores' => [
                        ['store_name'=>'Soon Lee','price'=>1.50,'distance'=>'3.2 km','rating'=>4.0,'is_favorite'=>false,'store_hours'=>'9AM-8PM'],
                        ['store_name'=>'Supa Save','price'=>1.80,'distance'=>'2.1 km','rating'=>4.2,'is_favorite'=>false,'store_hours'=>'8AM-9PM'], // ← Changed to false
                        ['store_name'=>'Hua Ho','price'=>2.00,'distance'=>'1.8 km','rating'=>4.4,'is_favorite'=>false,'store_hours'=>'7:30AM-10PM']
                    ]
                ]
            ]
        ]
    ];

    return $categories[strtolower($categoryName)] ?? null;
}
    // ---------------- Admin Methods ----------------

    /**
     * Show admin products index page
     */
    public function adminIndex()
    {
        $chickens = Product::all();

        // If no products exist, create sample data
        if ($chickens->count() === 0) {
            Product::create(['name'=>'Chicken Breast','category'=>'Meat','price'=>3.50,'stock'=>30,'status'=>'active']);
            Product::create(['name'=>'Whole Chicken','category'=>'Meat','price'=>5.50,'stock'=>30,'status'=>'active']);
            $chickens = Product::all();
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
     * Store new item
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

        return redirect()->route('admin.chicken-crud')
                         ->with('success', 'Item added successfully!');
    }

    /**
     * Show edit form
     */
    public function edit($id)
{
    $item = Product::findOrFail($id); // or Beef::findOrFail($id), etc.
    return view('admin.edititem', [
        'item' => $item,
        'updateRoute' => 'admin.chicken.update', // change per controller
        'backRoute' => 'admin.chicken-crud', // change per controller
    ]);
}

    /**
     * Update item
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->only(['name','category','price','stock']));

        return redirect()->route('admin.chicken-crud')->with('success', 'Item updated successfully');
    }

    /**
     * Delete item
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->back()->with('success', 'Item deleted successfully!');
    }
}
