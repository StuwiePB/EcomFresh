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

        return view('customer.main', compact('categories'));
    }
public function index()
    {
        $products = Product::all();
        return view('admin.items.index', compact('products'));
    }

    /**
     * Show Add Item form
     */
    public function create()
    {
        return view('admin.items.create'); // resources/views/admin/items/create.blade.php
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

}