<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Product;

class CatalogController extends Controller
{
 

    public function index(Request $request, $categoryId = 0){
        $categories = Group::where('id_parent', 0)
            ->with(['childrenRecursive.products', 'products'])
            ->get();
            
            
            // $products = collect();
            
            if ($categoryId)  {
                $category = Group::findOrFail($categoryId);
                $products = $category->allProducts()->with('price')->get();
            }
            else {
                $products = Product::with('price')->get();
            }
            
            
            
        return view('index', compact('categories','products'));
    }

   
}
