<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
                        [
                            'name' => 'Hua Ho',
                            'rating' => 4.4,
                            'distance' => 1.8,
                            'currentPrice' => 3.90,
                            'originalPrice' => 4.10,
                            'travelTime' => 5,
                            'hours' => '7:30AM–10PM'
                        ],
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
                            'name' => 'Hua Ho',
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
                            'name' => 'Hua Ho',
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

    // NEW METHOD FOR PRICE HISTORY
        public function priceHistory()
    {
        $data = [
            'location' => 'Gadong, Brunei',
            'products' => [
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
                ],
                [
                    'name' => 'Beansprouts',
                    'description' => 'Fresh • Quality Guaranteed',
                    'currentPrice' => 1.80,
                    'priceHistory' => [
                        'current' => 1.80,
                        'lastMonth' => 1.50,
                        'twoMonthsAgo' => 1.45,
                        'threeMonthsAgo' => 1.45
                    ],
                    'priceChange' => 0.30,
                    'percentageChange' => 20.0,
                    'trend' => 'increase'
                ]
            ]
        ];

        return view('customer.pricehistory', $data);
    }
}