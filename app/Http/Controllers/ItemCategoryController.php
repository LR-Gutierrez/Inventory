<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemCategoryController extends Controller
{
    public function index(){
        $order = '';
        if (request()->has('order')) {
            $order  = request('order') == 'asc' ? 'asc' : 'desc';     
            $itemCategories = ItemCategory::orderBy('id', $order)->paginate(5)->appends(['order' => $order]);
        }else {
            $itemCategories = ItemCategory::orderBy('id', 'asc')->paginate(5);
        }
        return view('ItemCategories.index', ['itemCategories' => $itemCategories, 'order' => $order, 'status' => '']);
    }
    public function create(){
        return view('ItemCategories.create');
    }
    public function store(Request $request){
        $request->validate([
            'description' => 'required|max:255',
        ]);
        $exists = ItemCategory::whereRaw('description = ?', ucwords(strtolower($request->description)))->exists();

        if ($exists) {
            return to_route('item-categories.index')->with('error', 'The item is already redistered.');
        }else {
            $itemCategory = new ItemCategory;
            $itemCategory->description = ucwords(strtolower($request->description));
            $itemCategory->created_by = Auth::user()->id;
            $itemCategory->save();
            return to_route('item-categories.index')->with('success', 'The item has successfully registered.');
        }
    }
    public function edit($id){
        $itemCategory = ItemCategory::find($id);
        return view('ItemCategories.edit', ['itemCategory' => $itemCategory]);
    }
    public function update(Request $request, $id){
        $request->validate([
            'description' => 'required|unique:item_categories,description,'.$id,
        ]);
        $itemCategory = ItemCategory::findOrFail($id);
        $itemCategory->description = ucwords(strtolower($request->description));
        $itemCategory->updated_by = Auth::user()->id;
        $itemCategory->save();
        return to_route('item-categories.index')->with('success', 'The item has been edited successfully.');
    }
    public function destroy($id){
        $itemCategory = ItemCategory::findOrFail($id);
        $itemCategory->delete();

        return to_route('item-categories.index')->with('success', 'The item has been deleted successfully.');
    }
}
