<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\TempOrder;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index() {
        $order = '';
        $status = '';
        if (request()->has('order')) {
            $order  = request('order') == 'asc' ? 'asc' : 'desc';     
            $sales = Sale::with('customers', 'coupons')->orderBy('id', $order)->paginate(5)->appends(['order' => $order]);
        }else {
            if (request()->has('status')) {
                $status = request('status') == 'active' ? true : false;
                $name = request('status') == 'active' ? 'active' : 'inactive';
                $sales = Sale::with('customers', 'coupons')->where('status', $status)->orderBy('id', 'asc')->paginate(5)->appends(['status' => $name]);
            }else {
                $sales = Sale::with('customers', 'coupons')->orderBy('id', 'asc')->paginate(5);
            }
        }
        // dd($sales);
        return view('Sales.index', ['order' => $order, 'sales' => $sales, 'status' => $status]);
    }
    public function create(){
        return view('Sales.create');
    }
    public function edit($id){
        $sale = Sale::findOrFail($id);
        return view('Sales.edit', ['sale' => $sale]);
    }
    public function desactivate($id){
        $sale = Sale::findOrFail($id);
        $sale->status = false;
        $sale->save();
        
        return to_route('sales.index')->with('success', 'The sale has been successfully desactivated');
    }
    public function activate($id){
        $sale = Sale::findOrFail($id);
        $sale->status = true;
        $sale->save();
        
        return to_route('sales.index')->with('success', 'The sale has been successfully activated');
    }
    public function remove(Request $request){
        $request->validate([
            'product_id' => 'required|integer',
            'customer_id' => 'required|integer',
        ]);
        $product = TempOrder::where('customer_id', $request->customer_id)->where('product_id',$request->product_id)->exists();
        if ($product === false) {
            $response = [
                'status' => 'error',
                'message' => 'There is no such product in the cart.',
                'data' => [],
            ];
            return response()->json($response, 200 );
        }
        $product = TempOrder::where('customer_id', $request->customer_id)->where('product_id',$request->product_id);
        $product->delete();
        
        $response = [
            'status' => 'success',
            'title' => 'Product removed!',
            'message' => 'The product has been successfuly removed from the cart.',
            'data' => [],
        ];
        return response()->json($response, 200);
    }
    public function update_amount(Request $request){
        $request->validate([
            'product_id' => 'required|integer',
            'customer_id' => 'required|integer',
            'item_quantity' => 'required|integer',
        ]);
        $temp_order = TempOrder::where('customer_id', $request->customer_id)->where('product_id',$request->product_id)->exists();
        if ($temp_order === false) {
            $response = [
                'status' => 'error',
                'message' => 'There is no such product in the cart.',
                'data' => [],
            ];
            return response()->json($response, 404);
        }
        $product = Product::find($request->product_id);
        $temp_order = TempOrder::where('customer_id', $request->customer_id)->where('product_id',$request->product_id)->first();
        $temp_order->item_quantity = $request->item_quantity;
        $temp_order->price = $product->price * $request->item_quantity;
        $temp_order->save();
        
        $response = [
            'status' => 'success',
            'title' => 'Order updated!',
            'message' => 'The order has been successfuly updated.',
            'data' => $temp_order,
        ];
        return response()->json($response, 200);
    }
}
