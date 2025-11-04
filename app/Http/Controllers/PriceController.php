<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PriceHistory;

class PriceController extends Controller
{
    public function todaysPrice()
    {
        $data = [
            'location' => 'Gadong, Brunei',
            'products' => [
                [
                    'name' => 'Chicken Breast',
                    'description' => 'Fresh • Quality Guaranteed',
                    'stores' => [
                        [
                            'name' => 'Soon Lee Bandar Seri Begawan',
                            'rating' => 4.2,
                            'distance' => 2.1,
                            'currentPrice' => 3.40,
                            'originalPrice' => 3.60,
                            'travelTime' => 6,
                            'hours' => '8AM–8PM'
                        ],
                        // Hua Ho removed — only Supa Save and Soon Lee are shown
                        [
                            'name' => 'Soon Lee Gadong',
                            'rating' => 4.0,
                            'distance' => 3.2,
                            'currentPrice' => 3.00,
                            'originalPrice' => 3.10,
                            'travelTime' => 10,
                            'hours' => '9AM–8PM'
                        ]
                    ]
                ],
                [
                    'name' => 'Ribeye Steak',
                    'description' => 'Fresh • Quality Guaranteed',
                    'stores' => [
                        [
                            'name' => 'Soon Lee Bandar Seri Begawan',
                            'rating' => 4.2,
                            'distance' => 2.1,
                            'currentPrice' => 17.95,
                            'originalPrice' => 18.75,
                            'travelTime' => 6,
                            'hours' => '8AM–9PM'
                        ],
                        [
                            'name' => 'Soon Lee Gadong',
                            'rating' => 4.0,
                            'distance' => 3.2,
                            'currentPrice' => 16.90,
                            'originalPrice' => 17.90,
                            'travelTime' => 10,
                            'hours' => '9AM–8PM'
                        ]
                    ]
                ],
                [
                    'name' => 'Beansprouts',
                    'description' => 'Fresh • Quality Guaranteed',
                    'stores' => [
                        [
                            'name' => 'Soon Lee Gadong',
                            'rating' => 4.4,
                            'distance' => 1.8,
                            'currentPrice' => 1.80,
                            'originalPrice' => 2.00,
                            'travelTime' => 6,
                            'hours' => '7:30AM–10PM'
                        ],
                        [
                            'name' => 'Soon Lee Bandar Seri Begawan',
                            'rating' => 4.2,
                            'distance' => 2.1,
                            'currentPrice' => 1.50,
                            'originalPrice' => 1.80,
                            'travelTime' => 10,
                            'hours' => '8AM–9PM'
                        ]
                    ]
                ]
            ]
        ];

        return view('customer.todays-price', $data);
    }

    //new method for price history with database
        public function priceHistory($type = null, $id = null)
        {
            if ($type === 'category' && $id === 'beef') {
                return $this->beefPriceHistory();
            } elseif ($type === 'store' && $id === 'soonlee') {
                return $this->soonleePriceHistory();
            }

                // If price history exists in DB, read from DB and build product arrays
                if (PriceHistory::count() > 0) {
                    // If a category was requested, pass it along
                    $products = $this->fetchProductsFromDb(null, $type === 'category' ? $id : null);

                    $data = [
                        'location' => 'Gadong, Brunei',
                        'title' => 'Price History - All Products',
                        'products' => $products,
                    ];

                    return view('customer.pricehistory', $data);
                }

                if ($type === 'category' && $id === 'beef') {
                    return $this->beefPriceHistory();
                } elseif ($type === 'store' && $id === 'soonlee') {
                    return $this->soonleePriceHistory();
                }

                // Default: fallback to hard-coded arrays
                $data = [
                    'location' => 'Gadong, Brunei',
                    'title' => 'Price History - All Products',
                    'products' => $this->getAllProducts()
                ];

                return view('customer.pricehistory', $data);
        }

    // Beef prices
    public function beefPriceHistory()
    {
        $data = [
            'location' => 'Muara, Brunei',
            'title' => 'Beef Price History',
            'products' => $this->getBeefProducts()
        ];

        return view('customer.pricehistory', $data);
    }



    // Soon Lee prices
    public function soonleePriceHistory()
    {
        $data = [
            'location' => 'Sengkurong, Brunei',
            'title' => 'Soon Lee - Price Trend',
            'products' => $this->getSoonLeeProducts()
        ];

        return view('customer.pricehistory', $data);
    }

    // Soon Lee Gadong (branch) prices - branch-specific view
    public function soonleeGadongPriceHistory()
    {
        $data = [
            'location' => 'Gadong, Brunei',
            'title' => 'Soon Lee Gadong - Price Trend',
            'products' => $this->getSoonLeeProducts()
        ];

        return view('customer.pricehistory', $data);
    }

    // Soon Lee Bandar Seri Begawan (branch) prices
    public function soonleeBandarPriceHistory()
    {
        $data = [
            'location' => 'Bandar Seri Begawan, Brunei',
            'title' => 'Soon Lee Bandar Seri Begawan - Price Trend',
            'products' => $this->getSupaSaveProducts()
        ];

        return view('customer.pricehistory', $data);
    }

    // Supa Save prices (same layout as Soon Lee)
    public function supasavePriceHistory()
    {
        $data = [
            'location' => 'Muara, Brunei',
            'title' => 'SupaSave - Price Trend',
            'products' => $this->getSupaSaveProducts()
        ];

        return view('customer.pricehistory', $data);
    }

    /**
     * Store + Category specific price history/trend page.
     * Example: /soonlee-prices/chicken
     */
    public function storeCategoryPriceHistory($store, $category)
    {
        // Normalize slugs
        $storeSlug = strtolower(str_replace(' ', '', $store));
        $categorySlug = strtolower(str_replace(' ', '', $category));

        // Try DB-driven results first
        $products = $this->fetchProductsFromDb($storeSlug, $categorySlug);
        if (count($products) > 0) {
            // friendly store name / location guess
            if (str_contains($storeSlug, 'soon')) {
                $storeName = 'Soon Lee';
                $location = 'Sengkurong, Brunei';
            } elseif (str_contains($storeSlug, 'supa')) {
                $storeName = 'SupaSave';
                $location = 'Gadong, Brunei';
            } else {
                $storeName = ucwords(str_replace(['-', '_'], ' ', $storeSlug));
                $location = 'Gadong, Brunei';
            }

            $data = [
                'location' => $location,
                'title' => "$storeName - " . ucfirst($categorySlug) . " Price Trend",
                'products' => $products
            ];

            return view('customer.pricehistory', $data);
        }

        // Fallback: use in-code store lists when DB has no matching rows
        // Map store slug to products provider
        switch ($storeSlug) {
            case 'soonlee':
            case 'soon-leee':
            case 'soonlee-gadong':
                $storeProducts = $this->getSoonLeeProducts();
                $storeName = 'Soon Lee Gadong';
                $location = 'Gadong, Brunei';
                break;
            case 'soonlee-bandar':
            case 'soon-lee-bandar-seri-begawan':
                // we reuse the SupaSave product list shape for the second Soon Lee branch
                $storeProducts = $this->getSupaSaveProducts();
                $storeName = 'Soon Lee Bandar Seri Begawan';
                $location = 'Bandar Seri Begawan, Brunei';
                break;
            case 'supasave':
            case 'supa-save':
                $storeProducts = $this->getSupaSaveProducts();
                $storeName = 'SupaSave';
                $location = 'Gadong, Brunei';
                break;
            default:
                // Fallback to all products if store not recognized
                $storeProducts = $this->getAllProducts();
                $storeName = ucfirst($storeSlug);
                $location = 'Gadong, Brunei';
                break;
        }

        // Filter products by category keyword when possible
        $filtered = array_filter($storeProducts, function ($p) use ($categorySlug) {
            $name = strtolower($p['name']);
            if ($categorySlug === 'chicken' && str_contains($name, 'chicken')) return true;
            if ($categorySlug === 'beef' && str_contains($name, 'beef')) return true;
            if (($categorySlug === 'vegetables' || $categorySlug === 'vegetable') && (
                str_contains($name, 'bean') || str_contains($name, 'vegetable') || str_contains($name, 'sprout')
            )) return true;
            // If no clear match, include product when category is 'all' or unknown
            return false;
        });

        // If filtering removed everything, fall back to storeProducts
        $productsToShow = count($filtered) ? array_values($filtered) : $storeProducts;

        $data = [
            'location' => $location,
            'title' => "$storeName - " . ucfirst($categorySlug) . " Price Trend",
            'products' => $productsToShow
        ];

        return view('customer.pricehistory', $data);
    }

    /**
     * Admin API: create or update a product and its price history.
     * Expected JSON payload:
     * {
     *   "store_name": "SupaSave",
     *   "product_name": "Chicken Breast",
     *   "category": "chicken",
     *   "current_price": 3.40,
     *   "last_month_price": 3.45,
     *   "two_months_ago_price": 3.50,
     *   "three_months_ago_price": 3.60,
     *   "recorded_date": "2025-11-01"
     * }
     */
    public function storePriceRecord(Request $request)
    {
        $data = $request->validate([
            'store_name' => 'required|string|max:255',
            'product_name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'current_price' => 'required|numeric',
            'last_month_price' => 'required|numeric',
            'two_months_ago_price' => 'required|numeric',
            'three_months_ago_price' => 'required|numeric',
            'recorded_date' => 'required|date',
        ]);

        // Find or create store
        $store = DB::table('stores')->where('name', $data['store_name'])->first();
        if (! $store) {
            $storeId = DB::table('stores')->insertGetId([
                'name' => $data['store_name'],
                'location' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $storeId = $store->id;
        }

        // Find or create product
        $product = DB::table('products')->where('name', $data['product_name'])->where('store_id', $storeId)->first();
        if (! $product) {
            $productId = DB::table('products')->insertGetId([
                'name' => $data['product_name'],
                'description' => '',
                'category' => $data['category'],
                'store_id' => $storeId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $productId = $product->id;
        }

        // Insert price history record
        $id = DB::table('price_history')->insertGetId([
            'product_id' => $productId,
            'current_price' => $data['current_price'],
            'last_month_price' => $data['last_month_price'],
            'two_months_ago_price' => $data['two_months_ago_price'],
            'three_months_ago_price' => $data['three_months_ago_price'],
            'recorded_date' => $data['recorded_date'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true, 'id' => $id], 201);
    }
    // Product data methods
    private function getBeefProducts()
    {
        return [
            [
                'name' => 'Beef Ribeye Steak',
                'description' => 'Premium Quality • Fresh',
                'category' => 'beef',
                'currentPrice' => 16.80,
                'priceHistory' => [
                    'current' => 16.80,
                    'lastMonth' => 17.20,
                    'twoMonthsAgo' => 16.90,
                    'threeMonthsAgo' => 16.50
                ],
                'threeMonthHistory' => [16.90, 17.20, 16.80],
                'extraStats' => [
                    'average' => 17.0,
                    'min' => 16.90,
                    'max' => 17.20,
                    'note' => '3-month avg'
                ],
                'priceChange' => -0.40,
                'percentageChange' => -2.33,
                'trend' => 'decrease'
            ]
        ];
    }

    /**
     * Fetch products and latest price history from the DB.
     * If storeSlug is provided, filter to that store. If category provided, filter by category.
     */
    private function fetchProductsFromDb($storeSlug = null, $category = null)
    {
        $query = DB::table('price_history as ph')
            ->join('products as p', 'ph.product_id', '=', 'p.id')
            ->join('stores as s', 'p.store_id', '=', 's.id')
            ->select(
                'p.id as product_id',
                'p.name as product_name',
                'p.description as product_description',
                'p.category as product_category',
                's.name as store_name',
                'ph.current_price',
                'ph.last_month_price',
                'ph.two_months_ago_price',
                'ph.three_months_ago_price',
                'ph.recorded_date'
            );

        if ($storeSlug) {
            $storeName = str_replace('-', ' ', $storeSlug);
            $query->where('s.name', 'like', "%{$storeName}%");
        }

        if ($category) {
            $query->where('p.category', $category);
        }

        // Grab latest records per product (group by product_id taking max recorded_date)
        $sub = DB::table('price_history')
            ->select(DB::raw('product_id, MAX(recorded_date) as md'))
            ->groupBy('product_id');

        $query->joinSub($sub, 'latest', function ($join) {
            $join->on('ph.product_id', '=', 'latest.product_id')
                 ->on('ph.recorded_date', '=', 'latest.md');
        });

        $rows = $query->get();

        $products = [];
        foreach ($rows as $r) {
            $current = (float)$r->current_price;
            $last = (float)$r->last_month_price;

            // compute change and percentage (guard division by zero)
            $priceChange = $current - $last;
            $percentageChange = $last != 0 ? ($priceChange / $last) * 100 : 0;

            // determine trend
            if ($priceChange > 0) {
                $trend = 'increase';
            } elseif ($priceChange < 0) {
                $trend = 'decrease';
            } else {
                $trend = 'stable';
            }

            $products[] = [
                'name' => $r->product_name,
                'category' => $r->product_category ?? 'general',
                'description' => $r->product_description,
                'currentPrice' => $current,
                'priceHistory' => [
                    'current' => $current,
                    'lastMonth' => $last,
                    'twoMonthsAgo' => (float)$r->two_months_ago_price,
                    'threeMonthsAgo' => (float)$r->three_months_ago_price,
                ],
                'threeMonthHistory' => [(float)$r->two_months_ago_price, (float)$r->last_month_price, $current],
                'extraStats' => [
                    'average' => round(((float)$r->two_months_ago_price + (float)$r->last_month_price + $current) / 3, 4),
                    'min' => min((float)$r->two_months_ago_price, (float)$r->last_month_price, $current),
                    'max' => max((float)$r->two_months_ago_price, (float)$r->last_month_price, $current),
                    'note' => 'DB-driven 3-month avg'
                ],
                'trend' => $trend,
                'priceChange' => round($priceChange, 2),
                'percentageChange' => round($percentageChange, 2),
            ];
        }

        return $products;
    }

    // Hua Ho product history removed; this app now supports Soon Lee and Supa Save only.

    private function getSoonLeeProducts()
    {
        return [
            [
                'name' => 'Chicken Breast - Soon Lee',
                'description' => 'Fresh • Quality Guaranteed',
                'category' => 'chicken',
                'currentPrice' => 3.65,
                'priceHistory' => [
                    'current' => 3.65,
                    'lastMonth' => 3.55,
                    'twoMonthsAgo' => 3.60,
                    'threeMonthsAgo' => 3.50
                ],
                'priceChange' => +0.10,
                'percentageChange' => +1.41,
                'trend' => 'increase'
            ]
        ];
    }

    private function getSupaSaveProducts()
    {
        return [
            [
                'name' => 'Chicken Breast - SupaSave',
                'description' => 'Fresh • Budget Friendly',
                'category' => 'chicken',
                'currentPrice' => 3.40,
                'priceHistory' => [
                    'current' => 3.40,
                    'lastMonth' => 3.45,
                    'twoMonthsAgo' => 3.50,
                    'threeMonthsAgo' => 3.60
                ],
                'priceChange' => -0.05,
                'percentageChange' => -1.45,
                'trend' => 'decrease'
            ]
        ];
    }

    private function getAllProducts()
    {
        return [
            [
                'name' => 'Chicken Breast',
                'description' => 'Fresh • Quality Guaranteed',
                'category' => 'chicken',
                'currentPrice' => 3.60,
                'priceHistory' => [
                    'current' => 3.60,
                    'lastMonth' => 3.70,
                    'twoMonthsAgo' => 3.65,
                    'threeMonthsAgo' => 3.80
                ],
                'priceChange' => -0.10,
                'percentageChange' => -2.7,
                'trend' => 'decrease'
            ],
            [
                'name' => 'Ribeye Steak',
                'description' => 'Fresh • Quality Guaranteed',
                'category' => 'beef',
                'currentPrice' => 18.30,
                'priceHistory' => [
                    'current' => 18.30,
                    'lastMonth' => 17.90,
                    'twoMonthsAgo' => 17.50,
                    'threeMonthsAgo' => 17.20
                ],
                'priceChange' => 0.40,
                'percentageChange' => 2.23,
                'trend' => 'increase'
            ]
        ];
    }
}