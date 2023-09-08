<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
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
                $business_manager = Customer::where('dni', $dni)->first();
                $response = [
                    'status' => 'success',
                    'message' => 'Client found!',
                    'data' => $business_manager
                ];
                return response()->json($response, 200);
            }else {
                $response = [
                    'status' => 'info',
                    'message' => 'Client not founded!',
                    'data' => []
                ];
                return response()->json($response, 200);
            }
    
        }else{
            return null;
        }
    }
}
