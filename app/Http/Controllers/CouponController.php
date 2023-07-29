<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function index(){
        $order = '';
        $status = '';
        if (request()->has('order')) {
            $order  = request('order') == 'asc' ? 'asc' : 'desc';     
            $coupons = Coupon::orderBy('id', $order)->paginate(5)->appends(['order' => $order]);
        }else {
            if (request()->has('status')) {
                $status = request('status') == 'active' ? true : false;
                $name = request('status') == 'active' ? 'active' : 'inactive';
                $coupons = Coupon::where('status', $status)->orderBy('id', 'asc')->paginate(5)->appends(['status' => $name]);
            }else {
                $coupons = Coupon::orderBy('id', 'asc')->paginate(5);
            }
        }
        return view('coupons.index', ['coupons' => $coupons, 'order' => $order, 'status' => $status]);
    }
    public function create(){
        return view('coupons.create');
    }
    public function store(CouponRequest $request){
        if (Coupon::where('coupon_code', strtoupper($request->coupon_code))->exists()) {
            return redirect()->back()->with('error', 'The coupon code is already taken.')->withInput();
        } else {
            $claimable = str_replace(',','', $request->claimable);
            if (!is_numeric($claimable)) {
                return redirect()->back()->with('error', 'The claimable field must be a number.')->withInput();
            }else{
                $coupon = new Coupon;
                $coupon->name = ucwords($request->name);
                $coupon->description = ucwords($request->description);
                $coupon->discount_amount = str_replace('%','', $request->discount_amount);
                $coupon->coupon_code = strtoupper($request->coupon_code);
                $coupon->claimable = $claimable;
                $coupon->created_by = Auth::user()->id;
                $coupon->save();
                
                return to_route('coupons.index')->with('success', 'The coupon code has been successfully created.');
            }
        }
    }
    public function edit($id){
        $coupon = Coupon::find($id);
        return view('Coupons.edit', ['coupon' => $coupon]);
    }
    public function update(CouponRequest $request, $id){
        if (Coupon::where('id', '!=', $id)->where('coupon_code',strtoupper($request->coupon_code))->exists()) {
            return redirect()->back()->with('error', 'The coupon code is already taken.')->withInput();
        } else {
            $claimable = str_replace(',','', $request->claimable);
            if (!is_numeric($claimable)) {
                return redirect()->back()->with('error', 'The claimable field must be a number.')->withInput();
            }else{
                $coupon = Coupon::find($id);
                $coupon->name = ucwords($request->name);
                $coupon->description = ucwords($request->description);
                $coupon->discount_amount = str_replace('%','', $request->discount_amount);
                $coupon->coupon_code = strtoupper($request->coupon_code);
                $coupon->claimable = $claimable;
                $coupon->updated_by = Auth::user()->id;
                $coupon->save();
                
                return to_route('coupons.index')->with('success', 'The coupon code has been successfully saved.');
            }
        }
    }
    public function destroy($id){
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();
        
        return to_route('coupons.index')->with('success', 'The coupon has been successfully deleted.');
    }
    public function desactivate($id){
        $coupon = Coupon::findOrFail($id);
        $coupon->status = false;
        $coupon->save();
        
        return to_route('coupons.index')->with('success', 'The coupon has been successfully desactivated');
    }
    public function activate($id){
        $coupon = Coupon::findOrFail($id);
        $coupon->status = true;
        $coupon->save();
        
        return to_route('coupons.index')->with('success', 'The coupon has been successfully activated');
    }
}
