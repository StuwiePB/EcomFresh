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
                            'name' => 'Supa Save',
                            'rating' => 4.2,
                            'distance' => 2.1,
                            'currentPrice' => 9.00,
                            'originalPrice' => 10.00,
                            'travelTime' => 6,
                            'hours' => '8AM–9PM'
                        ],
                        [
                            'name' => 'Soon Lee',
                            'rating' => 4.0,
                            'distance' => 3.2,
                            'currentPrice' => 7.20,
                            'originalPrice' => 8.50,
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
                            'originalPrice' => 1.90,
                            'travelTime' => 6,
                            'hours' => '7:30AM–10PM'
                        ],
                        [
                            'name' => 'Supa Save',
                            'rating' => 4.2,
                            'distance' => 2.1,
                            'currentPrice' => 2.10,
                            'originalPrice' => 2.40,
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
                    'currentPrice' => 3.40,
                    'priceHistory' => [
                        'current' => 3.40,
                        'lastMonth' => 3.70,
                        'twoMonthsAgo' => 3.65,
                        'threeMonthsAgo' => 3.80
                    ],
                    'priceChange' => -0.30,
                    'percentageChange' => -8.1,
                    'trend' => 'decrease'
                ],
                [
                    'name' => 'Ribeye Steak',
                    'description' => 'Fresh • Quality Guaranteed',
                    'currentPrice' => 18.90,
                    'priceHistory' => [
                        'current' => 18.90,
                        'lastMonth' => 17.90,
                        'twoMonthsAgo' => 17.50,
                        'threeMonthsAgo' => 17.20
                    ],
                    'priceChange' => 1.00,
                    'percentageChange' => 5.6,
                    'trend' => 'increase'
                ],
                [
                    'name' => 'Beansprouts',
                    'description' => 'Fresh • Quality Guaranteed',
                    'currentPrice' => 1.20,
                    'priceHistory' => [
                        'current' => 1.20,
                        'lastMonth' => 1.20,
                        'twoMonthsAgo' => 1.25,
                        'threeMonthsAgo' => 1.30
                    ],
                    'priceChange' => 0.00,
                    'percentageChange' => 0.0,
                    'trend' => 'stable'
                ]
            ]
        ];

        return view('customer.pricehistory', $data);
    }
}