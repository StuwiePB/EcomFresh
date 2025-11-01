<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CustomerCategory;
use App\Models\CustomerStore;
use App\Models\CustomerProduct;
use Illuminate\Support\Facades\DB;

class CustomerDataSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data
        DB::table('customer_product_prices')->delete();
        DB::table('customer_favorites')->delete();
        DB::table('customer_products')->delete();
        DB::table('customer_stores')->delete();
        DB::table('customer_categories')->delete();

        // 1. Create Categories
        $categories = [
            [
                'name' => 'Chicken',
                'slug' => 'chicken',
                'description' => 'Fresh poultry products at the best prices',
                'image' => 'images/categories/chicken.jpg',
                'icon' => 'drumstick-bite'
            ],
            [
                'name' => 'Beef',
                'slug' => 'beef', 
                'description' => 'Quality beef selections across stores',
                'image' => 'images/categories/beef.jpg',
                'icon' => 'hamburger'
            ],
            [
                'name' => 'Vegetables',
                'slug' => 'vegetables',
                'description' => 'Fresh vegetables from local markets',
                'image' => 'images/categories/vegetables.jpg',
                'icon' => 'carrot'
            ]
        ];

        foreach ($categories as $categoryData) {
            CustomerCategory::create($categoryData);
        }

        // 2. Create Stores (simplified - removed contact_number and address)
        $stores = [
            [
                'name' => 'Hua Ho',
                'slug' => 'hua-ho',
                'location' => 'Bander Seri Begawan',
                'store_hours' => '7:30AM-10PM',
                'rating' => 4.4
            ],
            [
                'name' => 'Supa Save',
                'slug' => 'supa-save', 
                'location' => 'Bander Seri Begawan',
                'store_hours' => '8AM-9PM',
                'rating' => 4.2
            ],
            [
                'name' => 'Soon Lee',
                'slug' => 'soon-lee',
                'location' => 'Bander Seri Begawan', 
                'store_hours' => '9AM-8PM',
                'rating' => 4.0
            ]
        ];

        foreach ($stores as $storeData) {
            CustomerStore::create($storeData);
        }

        // 3. Create Products and Prices (same as before)
        $productsData = [
            'chicken' => [
                [
                    'name' => 'Chicken Breast',
                    'slug' => 'chicken-breast',
                    'description' => 'Fresh chicken breast fillets',
                    'image' => 'images/products/chicken-breast.jpg',
                    'prices' => [
                        ['store' => 'Supa Save', 'current_price' => 3.60, 'original_price' => 4.20],
                        ['store' => 'Hua Ho', 'current_price' => 4.10, 'original_price' => null],
                        ['store' => 'Soon Lee', 'current_price' => 3.30, 'original_price' => 4.00]
                    ]
                ],
                [
                    'name' => 'Whole Chicken', 
                    'slug' => 'whole-chicken',
                    'description' => 'Fresh whole chicken',
                    'image' => 'images/products/whole-chicken.jpg',
                    'prices' => [
                        ['store' => 'Supa Save', 'current_price' => 5.50, 'original_price' => null],
                        ['store' => 'Hua Ho', 'current_price' => 6.30, 'original_price' => 7.00]
                    ]
                ],
                [
                    'name' => 'Chicken Thigh',
                    'slug' => 'chicken-thigh',
                    'description' => 'Fresh chicken thigh pieces', 
                    'image' => 'images/products/chicken-thigh.jpg',
                    'prices' => [
                        ['store' => 'Hua Ho', 'current_price' => 4.25, 'original_price' => 5.00],
                        ['store' => 'Supa Save', 'current_price' => 4.10, 'original_price' => 4.50],
                        ['store' => 'Soon Lee', 'current_price' => 3.95, 'original_price' => null]
                    ]
                ]
            ],
            'beef' => [
                [
                    'name' => 'Chuck Steak',
                    'slug' => 'chuck-steak',
                    'description' => 'Quality chuck steak cuts',
                    'image' => 'images/products/chuck-steak.jpg', 
                    'prices' => [
                        ['store' => 'Hua Ho', 'current_price' => 13.50, 'original_price' => 15.00],
                        ['store' => 'Supa Save', 'current_price' => 12.00, 'original_price' => 13.50],
                        ['store' => 'Soon Lee', 'current_price' => 11.80, 'original_price' => 14.00]
                    ]
                ],
                [
                    'name' => 'Ribeye Steak',
                    'slug' => 'ribeye-steak',
                    'description' => 'Premium ribeye steak',
                    'image' => 'images/products/ribeye-steak.jpg',
                    'prices' => [
                        ['store' => 'Hua Ho', 'current_price' => 18.75, 'original_price' => null],
                        ['store' => 'Supa Save', 'current_price' => 17.90, 'original_price' => 20.50]
                    ]
                ],
                [
                    'name' => 'Striploin Steak',
                    'slug' => 'striploin-steak',
                    'description' => 'Tender striploin steak',
                    'image' => 'images/products/striploin-steak.jpg',
                    'prices' => [
                        ['store' => 'Supa Save', 'current_price' => 16.50, 'original_price' => null],
                        ['store' => 'Hua Ho', 'current_price' => 17.20, 'original_price' => 19.00]
                    ]
                ]
            ],
            'vegetables' => [
                [
                    'name' => 'Carrots',
                    'slug' => 'carrots',
                    'description' => 'Fresh organic carrots',
                    'image' => 'images/products/carrots.jpg',
                    'prices' => [
                        ['store' => 'Supa Save', 'current_price' => 2.50, 'original_price' => 3.00],
                        ['store' => 'Hua Ho', 'current_price' => 3.10, 'original_price' => null],
                        ['store' => 'Soon Lee', 'current_price' => 2.30, 'original_price' => 2.70]
                    ]
                ],
                [
                    'name' => 'Cabbages',
                    'slug' => 'cabbages', 
                    'description' => 'Fresh green cabbages',
                    'image' => 'images/products/cabbages.jpg',
                    'prices' => [
                        ['store' => 'Hua Ho', 'current_price' => 2.80, 'original_price' => 3.20],
                        ['store' => 'Supa Save', 'current_price' => 2.60, 'original_price' => null]
                    ]
                ],
                [
                    'name' => 'Bean Sprouts',
                    'slug' => 'bean-sprouts',
                    'description' => 'Fresh bean sprouts',
                    'image' => 'images/products/beansprouts.jpg',
                    'prices' => [
                        ['store' => 'Soon Lee', 'current_price' => 1.50, 'original_price' => null],
                        ['store' => 'Supa Save', 'current_price' => 1.80, 'original_price' => 2.20],
                        ['store' => 'Hua Ho', 'current_price' => 2.00, 'original_price' => 2.50]
                    ]
                ]
            ]
        ];

        // Insert products and prices
        foreach ($productsData as $categorySlug => $products) {
            $category = CustomerCategory::where('slug', $categorySlug)->first();
            
            foreach ($products as $productData) {
                $product = CustomerProduct::create([
                    'category_id' => $category->id,
                    'name' => $productData['name'],
                    'slug' => $productData['slug'],
                    'description' => $productData['description'],
                    'image' => $productData['image']
                ]);

                // Create prices for each store
                foreach ($productData['prices'] as $priceData) {
                    $store = CustomerStore::where('name', $priceData['store'])->first();
                    
                    DB::table('customer_product_prices')->insert([
                        'product_id' => $product->id,
                        'store_id' => $store->id,
                        'current_price' => $priceData['current_price'],
                        'original_price' => $priceData['original_price'],
                        'is_discounted' => !is_null($priceData['original_price']),
                        'price_updated_at' => now(),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        }

        $this->command->info('Customer data seeded successfully!');
        $this->command->info('Categories: ' . CustomerCategory::count());
        $this->command->info('Stores: ' . CustomerStore::count()); 
        $this->command->info('Products: ' . CustomerProduct::count());
        $this->command->info('Prices: ' . DB::table('customer_product_prices')->count());
    }
}