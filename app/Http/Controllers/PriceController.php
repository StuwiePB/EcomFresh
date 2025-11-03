<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                            'name' => 'Supa Save',
                            'rating' => 4.2,
                            'distance' => 2.1,
                            'currentPrice' => 3.40,
                            'originalPrice' => 3.60,
                            'travelTime' => 6,
                            'hours' => '8AM–8PM'
                        ],
                        // Hua Ho removed — only Supa Save and Soon Lee are shown
                        [
                            'name' => 'Soon Lee',
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
                            'name' => 'Supa Save',
                            'rating' => 4.2,
                            'distance' => 2.1,
                            'currentPrice' => 17.95,
                            'originalPrice' => 18.75,
                            'travelTime' => 6,
                            'hours' => '8AM–9PM'
                        ],
                        [
                            'name' => 'Soon Lee',
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
                            'name' => 'Soon Lee',
                            'rating' => 4.4,
                            'distance' => 1.8,
                            'currentPrice' => 1.80,
                            'originalPrice' => 2.00,
                            'travelTime' => 6,
                            'hours' => '7:30AM–10PM'
                        ],
                        [
                            'name' => 'Supa Save',
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

            // Default: all products
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
            'location' => 'Gadong, Brunei',
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
            'title' => 'Soon Lee - Price History',
            'products' => $this->getSoonLeeProducts()
        ];

        return view('customer.pricehistory', $data);
    }

    // Product data methods
    private function getBeefProducts()
    {
        return [
            [
                'name' => 'Beef Ribeye Steak',
                'description' => 'Premium Quality • Fresh',
                'currentPrice' => 18.50,
                'priceHistory' => [
                    'current' => 18.50,
                    'lastMonth' => 18.20,
                    'twoMonthsAgo' => 17.80,
                    'threeMonthsAgo' => 17.50
                ],
                'priceChange' => 0.30,
                'percentageChange' => 1.65,
                'trend' => 'increase'
            ],
            [
                'name' => 'Beef Sirloin',
                'description' => 'Premium Quality • Fresh',
                'currentPrice' => 16.80,
                'priceHistory' => [
                    'current' => 16.80,
                    'lastMonth' => 17.20,
                    'twoMonthsAgo' => 16.90,
                    'threeMonthsAgo' => 16.50
                ],
                'priceChange' => -0.40,
                'percentageChange' => -2.33,
                'trend' => 'decrease'
            ]
        ];
    }

    // Hua Ho product history removed; this app now supports Soon Lee and Supa Save only.

    private function getSoonLeeProducts()
    {
        return [
            [
                'name' => 'Chicken Breast - Soon Lee',
                'description' => 'Fresh • Quality Guaranteed',
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

    private function getAllProducts()
    {
        return [
            [
                'name' => 'Chicken Breast',
                'description' => 'Fresh • Quality Guaranteed',
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