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
        // suppliers
        if ($request->supplier_id == 'none') {
            $supplier_id = null;
        }elseif($request->supplier_id == 'new'){
            $request->validate([
                'company_name' => 'required|max:255|unique:suppliers,company_name',
                'tin' => 'required|max:255|unique:suppliers,tin',
                'address' => 'required',
                'phone' => 'required|max:255|min:13|unique:suppliers,phone',
                'email' => 'required|email|unique:suppliers,email',
                'business_manager' => 'required',
            ]);
            if ($request->business_manager == 'new') {
                $request->validate([
                    'name' => 'required|max:255',
                    'lastname' => 'required|max:255',
                    'email' => 'required|email|unique:business_managers,email',
                    'phone' => 'required|max:255|unique:business_managers,phone',
                ]);
                $businessManager = new BusinessManager();
                $businessManager->name = ucwords($request->business_manager_name);
                $businessManager->lastname = ucwords($request->business_manager_lastname);
                $businessManager->email = $request->business_manager_email;
                $businessManager->phone = $request->business_manager_phone;
                $businessManager->created_by = Auth::user()->id;
                $businessManager->save();
                $businessManager_id = $businessManager->id; 
            }else{
                $businessManager_id = $request->business_manager;
            }
            
            $supplier = new Supplier();
            $supplier->company_name = ucwords($request->company_name);
            $supplier->tin = ucwords($request->tin);
            $supplier->address = $request->address;
            $supplier->phone = $request->phone;
            $supplier->email = $request->email;
            $supplier->website = $request->website;
            $supplier->business_manager_id = $businessManager_id;
            $supplier->created_by = Auth::user()->id;
            $supplier->save();
            $supplier_id = $supplier->id;
        }else {
            $supplier_id = $request->supplier_id;
        }
        // item category
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
        $businessManagers = BusinessManager::all();
        return view('Products.edit', ['product' => $product, 'businessManagers' => $businessManagers]);
    }
}