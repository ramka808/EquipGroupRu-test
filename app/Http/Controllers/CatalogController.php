<?php
namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class CatalogController extends Controller
{

    public function index(Request $request, $categoryId = 0)
    {
        $categories = Group::where('id_parent', 0)
            ->with(['childrenRecursive.products', 'products'])
            ->get();

        if ($categoryId) {
            $category = Group::findOrFail($categoryId);
            $products = $category->allProducts()->with('price')->get();
        } else {
            $products = Product::with('price')->get();
        }

        return view('index', compact('categories', 'products', 'categoryId'));
    }

    public function getProductsByCategoryAjax(Request $request, $categoryId = 0)
    {

        $sort = $request->query('sort');
        $perPage = $request->query('perPage');

        if ($categoryId) {
            $category = Group::findOrFail($categoryId);
            $products = $category->allProducts()->with('price');
            
        } else {
            $products = Product::with('price');
        }
        // dd($products->first());
        switch ($sort) {
            case 'price_asc':
                $products = $products->join('prices', 'products.id', '=', 'prices.id_product')
                                     ->orderBy('prices.price', 'asc')
                                     ->select('products.*');
                break;
            case 'price_desc':
                $products = $products->join('prices', 'products.id', '=', 'prices.id_product')
                                     ->orderBy('prices.price', 'desc')
                                     ->select('products.*');
                break;
            case 'name_asc':
                $products = $products->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $products = $products->orderBy('name', 'desc');
                break;
        }
        
        
        
        return response()->json($products->paginate($perPage));
    }
}
