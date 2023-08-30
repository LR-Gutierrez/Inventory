<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BusinessManager;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function index(){
        $order = '';
        if (request()->has('order')) {
            $order  = request('order') == 'asc' ? 'asc' : 'desc';     
            $suppliers = Supplier::orderBy('id', $order)->paginate(5)->appends(['order' => $order]);
        }else {
            $suppliers = Supplier::orderBy('id', 'asc')->paginate(5);
        }
        return view('Suppliers.index', ['suppliers' => $suppliers, 'order' => $order, 'status' => '']);
    }
    public function create(){
        $businessManagers = BusinessManager::all();
        return view('Suppliers.create', ['businessManagers' => $businessManagers]);
    }
    public function store(Request $request){
        $request->validate([
            'company_name' => 'required|max:255|unique:suppliers,company_name',
            'tin' => 'required|max:255|unique:suppliers,tin',
            'address' => 'required',
            'phone' => 'required|max:255|min:13|unique:suppliers,phone',
            'email' => 'required|email|unique:suppliers,email',
            'business_manager' => 'required',
        ]);
        if ($request->business_manager !== 'new') {
            $supplier = new Supplier;
            $supplier->company_name = $request->company_name;
            $supplier->tin = $request->tin;
            $supplier->business_manager_id = $request->business_manager;
            $supplier->address = $request->address;
            $supplier->phone = $request->phone;
            $supplier->email = $request->email;
            $supplier->website = $request->website;
            $supplier->created_by = Auth::user()->id;

            $supplier->save();
            return to_route('suppliers.index')->with('success', 'The supplier has been successfully created.');
        }else {
            if ($request->business_manager_name == '' || $request->business_manager_lastname == '' || $request->business_manager_email == '' || $request->business_manager_phone == '') {
                return redirect()->back()->with('error', 'One or more fields of the General business manager information is empty. Please check.')->withInput();
            }
            try {
                DB::transaction(function () use ($request) {
                    $business_manager = new BusinessManager;
                    $business_manager->name = $request->business_manager_name;
                    $business_manager->lastname = $request->business_manager_lastname;
                    $business_manager->phone = $request->business_manager_phone;
                    $business_manager->email = $request->business_manager_email;
                    $business_manager->created_by = Auth::user()->id;
                    $business_manager->save();
                    $business_manager_id = $business_manager->id;
                    
                    $supplier = new Supplier;
                    $supplier->company_name = $request->company_name;
                    $supplier->tin = $request->tin;
                    $supplier->business_manager_id = $business_manager_id;
                    $supplier->address = $request->address;
                    $supplier->phone = $request->phone;
                    $supplier->email = $request->email;
                    $supplier->website = $request->website;
                    $supplier->created_by = Auth::user()->id;
                    $supplier->save();
                });
                return to_route('suppliers.index')->with('success', 'The supplier and the business manager has been successfully created.');
            } catch (\Throwable $th) {
                DB::rollBack();
                return redirect()->back()->with('error', 'One or more errors have occurred, please contact technical support.')->withInput();

            }
        }
    }
    public function edit($id){
        $businessManagers = BusinessManager::all();
        $supplier = Supplier::find($id);

        return view('Suppliers.edit', ['supplier' => $supplier, 'businessManagers' => $businessManagers]);
    }
    public function update(Request $request, $id){
        $request->validate([
            'company_name' => 'required|max:255|unique:suppliers,company_name,'.$id,
            'tin' => 'required|max:255|unique:suppliers,tin,'.$id,
            'address' => 'required',
            'phone' => 'required|max:255|min:13|unique:suppliers,phone,'.$id,
            'email' => 'required|email|unique:suppliers,email,'.$id,
            'business_manager' => 'required',
        ]);
        if ($request->business_manager !== 'new') {
            $supplier = Supplier::find($id);
            $supplier->company_name = $request->company_name;
            $supplier->tin = $request->tin;
            $supplier->business_manager_id = $request->business_manager;
            $supplier->address = $request->address;
            $supplier->phone = $request->phone;
            $supplier->email = $request->email;
            $supplier->website = $request->website;
            $supplier->updated_by = Auth::user()->id;

            $supplier->save();
            return to_route('suppliers.index')->with('success', 'The supplier has been successfully updated.');
        }else {
            if ($request->business_manager_name == '' || $request->business_manager_lastname == '' || $request->business_manager_email == '' || $request->business_manager_phone == '') {
                return redirect()->back()->with('error', 'One or more fields of the General business manager information is empty. Please check.')->withInput();
            }
            try {
                DB::transaction(function () use ($request, $id) {
                    $business_manager = new BusinessManager;
                    $business_manager->name = $request->business_manager_name;
                    $business_manager->lastname = $request->business_manager_lastname;
                    $business_manager->phone = $request->business_manager_phone;
                    $business_manager->email = $request->business_manager_email;
                    $business_manager->created_by = Auth::user()->id;
                    $business_manager->save();
                    $business_manager_id = $business_manager->id;
                    
                    $supplier = Supplier::find($id);
                    $supplier->company_name = $request->company_name;
                    $supplier->tin = $request->tin;
                    $supplier->business_manager_id = $business_manager_id;
                    $supplier->address = $request->address;
                    $supplier->phone = $request->phone;
                    $supplier->email = $request->email;
                    $supplier->website = $request->website;
                    $supplier->updated_by = Auth::user()->id;
                    $supplier->save();
                });
                return to_route('suppliers.index')->with('success', 'The supplier and the business manager has been successfully updated.');
            } catch (\Throwable $th) {
                DB::rollBack();
                return redirect()->back()->with('error', 'One or more errors have occurred, please contact technical support.')->withInput();

            }
        }
    }
    public function destroy($id){
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        
        return to_route('suppliers.index')->with('success', 'The supplier has been successfully deleted.');
    }
    public function search(Request $request){
        $id = $request->business_manager_id;

        $business_manager = BusinessManager::find($id);

        return $business_manager;
    }
}
