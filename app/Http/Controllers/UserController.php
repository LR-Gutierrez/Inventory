<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        $order = '';
        if (request()->has('order')) {
            $order  = request('order') == 'asc' ? 'asc' : 'desc';     
            $users = User::orderBy('id', $order)->paginate(5)->appends(['order' => $order]);
        }else {
            $users = User::orderBy('id', 'asc')->paginate(5);
        }
        return view('Users/index', ['users' => $users, 'order' => $order, 'status' => '']);
    }
    public function create(){
        return view('Users.create');
    }
    public function store(CreateUserRequest $request){
        $user = new User;
        $user->name = ucwords($request->name);
        $user->lastname = ucwords($request->lastname);
        $user->email = $request->email;
        $user->dni = str_replace(' ', '', trim($request->dni));
        $user->password = Hash::make(str_replace(' ', '', trim($request->dni)));
        $user->username = $request->username;
        $user->created_by = Auth::user()->id;
        $user->save();
        return to_route('users.index')->with('success', 'The user has successfully registered.');
    }
    public function edit($id){
        $user = User::find($id);
        return view('Users.edit', ['user' => $user]);
    }
    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|max:255',
            'lastname' => 'required|max:255',
            'username' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'dni' => 'required|max:255|unique:users,dni,'.$id,
        ]);
        $user = User::findOrFail($id);
        $user->name = ucwords($request->name);
        $user->lastname = ucwords($request->lastname);
        $user->email = $request->email;
        $user->dni = str_replace(' ', '', trim($request->dni));
        $user->username = $request->username;
        $user->updated_by = Auth::user()->id;
        $user->save();
        return to_route('users.index')->with('success', 'The user has been edited successfully.');
    }
    public function destroy($id){
        $user = User::findOrFail($id);
        $user->delete();

        return to_route('users.index')->with('success', 'The user has been deleted successfully.');
    }
}
