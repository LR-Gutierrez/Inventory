<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\BasicInfoRequest;
use App\Models\BusinessManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessManagerController extends Controller
{
    public function index(){
        $order = '';
        if (request()->has('order')) {
            $order  = request('order') == 'asc' ? 'asc' : 'desc';     
            $businessManagers = BusinessManager::orderBy('id', $order)->paginate(5)->appends(['order' => $order]);
        }else {
            $businessManagers = BusinessManager::orderBy('id', 'asc')->paginate(5);
        }
        return view('BusinessManagers.index', ['businessManagers' => $businessManagers, 'order' => $order, 'status' => '']);
    }
    public function create(){
        return view('BusinessManagers.create');
    }
    public function store(BasicInfoRequest $request){
        $businessManager = new BusinessManager;
        $businessManager->name = ucwords($request->name);
        $businessManager->lastname = ucwords($request->lastname);
        $businessManager->email = $request->email;
        $businessManager->phone = $request->phone;
        $businessManager->created_by = Auth::user()->id;
        $businessManager->save();
        return to_route('business-managers.index')->with('success', 'The business manager has been successfully registered.');
    }
    public function edit($id){
        $businessManager = BusinessManager::find($id);
        return view('BusinessManagers.edit', ['businessManager' => $businessManager]);
    }
    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|email|unique:business_managers,email,'.$id,
            'phone' => 'required|max:255|unique:business_managers,phone,'.$id,
        ]);
        $businessManager = BusinessManager::findOrFail($id);
        $businessManager->name = ucwords($request->name);
        $businessManager->lastname = ucwords($request->lastname);
        $businessManager->email = $request->email;
        $businessManager->phone = $request->phone;
        $businessManager->updated_by = Auth::user()->id;
        $businessManager->save();
        return to_route('business-managers.index')->with('success', 'The business manager has been edited successfully.');
    }
    public function destroy($id){
        $businessManager = BusinessManager::findOrFail($id);
        $businessManager->delete();
        return to_route('business-managers.index')->with('success', 'The business manager has been deleted successfully.');
    }
}
