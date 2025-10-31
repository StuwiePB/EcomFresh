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
            return redirect('/customer');
        }

        return view('customer.category-products', compact('categoryData', 'category'));
    }

    /**
     * Hardcoded products data for each category with discount support
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
                            ['store_name'=>'Supa Save','price'=>3.60,'originalPrice'=>4.20,'distance'=>'2.1 km','rating'=>4.2,'is_favorite'=>false,'store_hours'=>'8AM-9PM'], // Added discount
                            ['store_name'=>'Hua Ho','price'=>4.10,'distance'=>'1.8 km','rating'=>4.4,'is_favorite'=>false,'store_hours'=>'7:30AM-10PM'], // No discount
                            ['store_name'=>'Soon Lee','price'=>3.30,'originalPrice'=>3.80,'distance'=>'3.2 km','rating'=>4.0,'is_favorite'=>false,'store_hours'=>'9AM-8PM'] // Added discount
                        ]
                    ],
                    [
                        'name' => 'Whole Chicken',
                        'image' => 'images/products/whole-chicken.jpg',
                        'stores' => [
                            ['store_name'=>'Supa Save','price'=>5.50,'distance'=>'2.1 km','rating'=>4.2,'is_favorite'=>false,'store_hours'=>'8AM-9PM'], // No discount
                            ['store_name'=>'Hua Ho','price'=>6.30,'originalPrice'=>7.50,'distance'=>'1.8 km','rating'=>4.4,'is_favorite'=>false,'store_hours'=>'7:30AM-10PM'] // Added discount
                        ]
                    ],
                    [
                        'name' => 'Chicken Thigh',
                        'image' => 'images/products/chicken-thigh.jpg',
                        'stores' => [
                            ['store_name'=>'Hua Ho','price'=>4.25,'originalPrice'=>5.00,'distance'=>'1.8 km','rating'=>4.4,'is_favorite'=>false,'store_hours'=>'7:30AM-10PM'], // Added discount
                            ['store_name'=>'Supa Save','price'=>4.10,'distance'=>'2.1 km','rating'=>4.2,'is_favorite'=>false,'store_hours'=>'8AM-9PM'], // No discount
                            ['store_name'=>'Soon Lee','price'=>3.95,'distance'=>'3.2 km','rating'=>4.0,'is_favorite'=>false,'store_hours'=>'9AM-8PM'] // No discount
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
                            ['store_name'=>'Hua Ho','price'=>13.50,'originalPrice'=>15.00,'distance'=>'1.8 km','rating'=>4.4,'is_favorite'=>false,'store_hours'=>'7:30AM-10PM'], // Added discount
                            ['store_name'=>'Supa Save','price'=>12.00,'distance'=>'2.1 km','rating'=>4.2,'is_favorite'=>false,'store_hours'=>'8AM-9PM'], // No discount
                            ['store_name'=>'Soon Lee','price'=>11.80,'originalPrice'=>13.20,'distance'=>'3.2 km','rating'=>4.0,'is_favorite'=>false,'store_hours'=>'9AM-8PM'] // Added discount
                        ]
                    ],
                    [
                        'name' => 'Ribeye Steak',
                        'image' => 'images/products/ribeye-steak.jpg',
                        'stores' => [
                            ['store_name'=>'Hua Ho','price'=>18.75,'distance'=>'1.8 km','rating'=>4.4,'is_favorite'=>false,'store_hours'=>'7:30AM-10PM'], // No discount
                            ['store_name'=>'Supa Save','price'=>17.90,'originalPrice'=>20.50,'distance'=>'2.1 km','rating'=>4.2,'is_favorite'=>false,'store_hours'=>'8AM-9PM'] // Added discount
                        ]
                    ],
                    [
                        'name' => 'Striploin Steak',
                        'image' => 'images/products/striploin-steak.jpg',
                        'stores' => [
                            ['store_name'=>'Supa Save','price'=>16.50,'distance'=>'2.1 km','rating'=>4.2,'is_favorite'=>false,'store_hours'=>'8AM-9PM'], // No discount
                            ['store_name'=>'Hua Ho','price'=>17.20,'originalPrice'=>19.00,'distance'=>'1.8 km','rating'=>4.4,'is_favorite'=>false,'store_hours'=>'7:30AM-10PM'] // Added discount
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
                            ['store_name'=>'Supa Save','price'=>2.50,'originalPrice'=>3.00,'distance'=>'2.1 km','rating'=>4.2,'is_favorite'=>false,'store_hours'=>'8AM-9PM'], // Added discount
                            ['store_name'=>'Hua Ho','price'=>3.10,'distance'=>'1.8 km','rating'=>4.4,'is_favorite'=>false,'store_hours'=>'7:30AM-10PM'], // No discount
                            ['store_name'=>'Soon Lee','price'=>2.30,'distance'=>'3.2 km','rating'=>4.0,'is_favorite'=>false,'store_hours'=>'9AM-8PM'] // No discount
                        ]
                    ],
                    [
                        'name' => 'Cabbages',
                        'image' => 'images/products/cabbages.jpg',
                        'stores' => [
                            ['store_name'=>'Hua Ho','price'=>2.80,'originalPrice'=>3.50,'distance'=>'1.8 km','rating'=>4.4,'is_favorite'=>false,'store_hours'=>'7:30AM-10PM'], // Added discount
                            ['store_name'=>'Supa Save','price'=>2.60,'distance'=>'2.1 km','rating'=>4.2,'is_favorite'=>false,'store_hours'=>'8AM-9PM'] // No discount
                        ]
                    ],
                    [
                        'name' => 'Bean Sprouts',
                        'image' => 'images/products/beansprouts.jpg',
                        'stores' => [
                            ['store_name'=>'Soon Lee','price'=>1.50,'distance'=>'3.2 km','rating'=>4.0,'is_favorite'=>false,'store_hours'=>'9AM-8PM'], // No discount
                            ['store_name'=>'Supa Save','price'=>1.80,'originalPrice'=>2.20,'distance'=>'2.1 km','rating'=>4.2,'is_favorite'=>false,'store_hours'=>'8AM-9PM'], // Added discount
                            ['store_name'=>'Hua Ho','price'=>2.00,'distance'=>'1.8 km','rating'=>4.4,'is_favorite'=>false,'store_hours'=>'7:30AM-10PM'] // No discount
                        ]
                    ]
                ]
            ]
        ];

        return $categories[strtolower($categoryName)] ?? null;
    }
}