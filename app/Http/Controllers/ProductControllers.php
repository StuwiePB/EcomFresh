<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $categories = [
            [
                'name' => 'Chicken',
                'description' => 'Fresh poultry products'
            ],
            [
                'name' => 'Beef', 
                'description' => 'Quality beef selections'
            ],
            [
                'name' => 'Vegetables',
                'description' => 'Farm-fresh vegetables'
            ],
            [
                'name' => 'Discounted produce',
                'description' => 'Special offers and discounts'
            ]
        ];

        return view('welcome', compact('categories'));
    }
}