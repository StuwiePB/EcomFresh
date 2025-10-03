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
                    'description' => 'Fresh + Quality Guaranteed',
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
                            'distance' => 1.5,
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
                ]
            ]
        ];

        return view('customer.todays-price', $data);
    }
}