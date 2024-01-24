<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\TempOrder;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
                $sales = Sale::with('customers', 'coupons')->where('status', $status)->orderBy('id', 'desc')->paginate(5)->appends(['status' => $name]);
            }else {
                $sales = Sale::with('customers', 'coupons')->orderBy('id', 'desc')->paginate(5);
            }
        }
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
    public function removeAll(Request $request){
        $request->validate([
            'body_checkbox' => 'required|array',
            'dni' => 'required|integer',
        ]);
        $dni = $request->dni;
        $products = TempOrder::with('customers')
            ->whereHas('customers', function($query) use ($dni){
                $query->where('dni', $dni);
            })
        ->exists();
        if ($products === false) {
            $response = [
                'status' => 'error',
                'message' => __("This customer doesn't have any products in the cart."),
                'data' => [],
            ];
            return response()->json($response, 200 );
        }else{
            foreach ($request->body_checkbox as $checkbox) {
                $product_id = $checkbox['value'];
                $products = TempOrder::with('customers')
                    ->whereHas('customers', function($query) use ($dni){
                            $query->where('dni', $dni);
                        })
                    ->where('product_id', $product_id)
                ->get();
                $products->each(function ($product) {
                    $product->delete();
                });
            }
            $products = TempOrder::with('customers', 'products.itemCategory')
                ->whereHas('customers', function($query) use ($dni){
                    $query->where('dni', $dni);
                })
            ->get();
        }       

        $response = [
            'status' => 'success',
            'title' => __('Products removed!'),
            'message' => __('The products has been successfuly removed from the cart.'),
            'orders' => $products,
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
        // $temp_order->price = $product->price * $request->item_quantity;
        $temp_order->save();
        
        $response = [
            'status' => 'success',
            'title' => 'Order updated!',
            'message' => 'The order has been successfuly updated.',
            'data' => $temp_order,
        ];
        return response()->json($response, 200);
    }
    public function store(Request $request){
        $request->validate([
            'dni' => 'required|string',
        ]);
        $dni = str_replace(' ', '', $request->dni);
        $coupon_code = $request->coupon_code != null ? $request->coupon_code : null;
        $customer = Customer::where('dni', $dni)->first();
        
        $products = TempOrder::with('customers', 'products.itemCategory')
            ->whereHas('customers', function($query) use ($dni){
                $query->where('dni', $dni);
            })
        ->count();
        if ($products == 0 ) {
            $response = [
                'status' => 'error',
                'title' => "Oops!",
                'message' => "This customer doesn't have any products on its cart.",
                'data' => []
            ];
            return response()->json($response);
        } 
        DB::statement('CALL execute_sale(?, ?, ?, ?)', array($customer->id, $coupon_code, Carbon::now(), Auth::user()->id));

        $products = TempOrder::with('customers', 'products.itemCategory')
            ->whereHas('customers', function($query) use ($dni){
                $query->where('dni', $dni);
            })
        ->count();
        if ($products > 0) {
            $response = [
                'status' => 'error',
                'title' => "Oops!",
                'message' => "An error may have ocurred.",
                'data' => []
            ];
            return response()->json($response);
        }
        $response = [
            'status' => 'success',
            'title' => 'Sold!',
            'message' => "The products has been successfuly sold.",
            'data' => [
                'url' => ''. route('sales.index').''
            ]
        ];
        return response()->json($response);
    }
}
