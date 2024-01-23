<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\TempOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index(){
        $order = '';
        if (request()->has('order')) {
            $order  = request('order') == 'asc' ? 'asc' : 'desc';     
            $customers = Customer::orderBy('id', $order)->paginate(5)->appends(['order' => $order]);
        }else {
            $customers = Customer::orderBy('id', 'asc')->paginate(5);
        }
        return view('Customers.index', ['customers' => $customers, 'order' => $order, 'status' => '']);
    }
    public function create(){
        return view('Customers.create');
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|email|unique:customers,email',
            'dni' => 'required|max:255|unique:customers,dni',
            'phone' => 'required|max:255|unique:customers,phone',
        ]);
        $customer = new Customer;
        $customer->name = ucwords($request->name);
        $customer->lastname = ucwords($request->lastname);
        $customer->email = $request->email;
        $customer->dni = str_replace(' ', '', trim($request->dni));
        $customer->phone = $request->phone;
        $customer->created_by = Auth::user()->id;
        $customer->save();
        return to_route('customers.index')->with('success', 'The customer has been successfully registered.');
    }
    public function edit($id){
        $customer = Customer::find($id);
        return view('Customers.edit', ['customer' => $customer]);
    }
    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|email|unique:customers,email,'.$id,
            'dni' => 'required|max:255|unique:customers,dni,'.$id,
            'phone' => 'required|max:255|unique:customers,phone,'.$id,
        ]);
        $customer = Customer::findOrFail($id);
        $customer->name = ucwords($request->name);
        $customer->lastname = ucwords($request->lastname);
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->dni = str_replace(' ', '', trim($request->dni));
        $customer->updated_by = Auth::user()->id;
        $customer->save();
        return to_route('customers.index')->with('success', 'The customer has been edited successfully.');
    }
    public function destroy($id){
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return to_route('customers.index')->with('success', 'The customer has been deleted successfully.');
    }
    public function search(Request $request){
        if ($request->dni) {
            $dni = $request->dni;
            if (Customer::where('dni', $dni)->exists() === true) {
                $customer = Customer::where('dni', $dni)->first();
                $temp_orders = TempOrder::where('customer_id', $customer->id)->with('products.itemCategory')->get();
                $response = [
                    'status' => 'success',
                    'message' => 'Customer found!',
                    'data' => $customer,
                    'orders' => $temp_orders,
                ];
                return response()->json($response, 200);
            }else {
                $response = [
                    'status' => 'info',
                    'message' => 'Customer not found, please register it',
                    'data' => []
                ];
                return response()->json($response);
            }
    
        }else{
            return null;
        }
    }
}
