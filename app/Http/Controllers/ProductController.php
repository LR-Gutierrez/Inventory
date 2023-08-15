<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ItemCategory;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(){
        $order = '';
        if (request()->has('order')) {
            $order  = request('order') == 'asc' ? 'asc' : 'desc';     
            $products = Product::orderBy('id', $order)->paginate(5)->appends(['order' => $order]);
        }else {
            $products = Product::orderBy('id', 'asc')->paginate(5);
        }
        
        return view('Products.index', ['products' => $products, 'order' => $order, 'status' => '']);
    }
    public function create(){
        $supplier = Supplier::all();
        $itemCategories = ItemCategory::all();
        return view('Products.create', ['suppliers' => $supplier, 'itemCategories' => $itemCategories]);
    }
    public function store(Request $request){
        $product = new Product;
        $product->name = ucwords($request->name);
        $product->description = ucwords($request->description);
        $product->item_quantity = $request->item_quantity;
        $product->price = str_replace(' ', '', trim($request->price));
        $product->supplier_id = $request->supplier_id;
        $product->item_category_id = $request->item_category_id;
        $product->expiration_date = $request->expiration_date;
        $product->created_by = Auth::user()->id;
        $product->save();
        return to_route('users.index')->with('success', 'The user has successfully registered.');
    }
}
