<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        return Product::select('id', 'name', 'price', 'qty_stock')->get();
    }

    public function stock()
    {
        return Product::select('name', 'qty_stock')
            ->orderBy('name')
            ->get();
    }
}
