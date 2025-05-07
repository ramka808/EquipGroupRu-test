<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Group;


class ProductController extends Controller
{
    public function index($id) {
       
        $product = Product::with('price')->findorFail($id);
        $parentCategories = Group::find($product->id_group)->parentRecursive()->get();
        
        // $parentCategories = $parentCategories->reverse()->values();
        $parentCategories = $parentCategories->sortBy('id');
        // \dd($parentCategories);
        return view('product.index', compact('product', 'parentCategories'));
    }
}