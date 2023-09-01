<?php

namespace App\Http\Controllers;

use App\Models\Sale;
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
        return view('Sales.create', ['sale' => null]);
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
}
