<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BusinessManager;
use App\Models\ItemCategory;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Auth\Events\Validated;
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
        $businessManagers = BusinessManager::all();
        return view('Products.create', ['suppliers' => $supplier, 'itemCategories' => $itemCategories, 'businessManagers' => $businessManagers]);
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'item_quantity' => 'required',
            'price' => 'required',
            'item_category_id' => 'required',
        ]);
        $supplier_id = $request->supplier_id == 'none' ? null : $request->supplier_id;
        if ($request->item_category_id == 1){
            $request->validate([
                'new_category' => 'required',
            ]);
            $category = new ItemCategory();
            $category->description = $request->new_category;
            $category->created_by = Auth::user()->id;
            $category->save();
            $category_id = $category->id;
        }else {
            $category_id = $request->item_category_id;
        }
        $product = new Product;
        $product->name = ucwords($request->name);
        $product->description = ucwords($request->description);
        $product->item_quantity = $request->item_quantity;
        $product->price = str_replace(',', '', $request->price);
        $product->supplier_id = $supplier_id;
        $product->item_category_id = $category_id;
        $product->expiration_date = $request->expiration_date;
        $product->created_by = Auth::user()->id;
        $product->save();
        return to_route('products.index')->with('success', 'The product has successfully registered.');
    }
    public function edit($id){
        $product = Product::find($id);
        return view('Products}.edit', ['product' => $product]);
    }
}
