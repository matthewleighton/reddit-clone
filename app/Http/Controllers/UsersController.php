<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Hash;

class UsersController extends Controller
{
    public function create()
    {
    	return view('users.create');
    }

    public function save(Request $request)
    {
    	/*$rules = array(
    		'name' => 'required|unique:users',
    		'password' => 'required|min:5|confirmed',
    		'password_confirmation' => 'required|min:5',
    		'email' => 'required|email|unique:users'
    	);*/

    	$this->validate($request, [
    		'name' => 'required|unique:users',
    		'password' => 'required|min:5|confirmed',
    		'password_confirmation' => 'required|min:5',
    		'email' => 'required|email|unique:users'
    	]);

    	/*$validator = Validator::make(Input::all(), $rules);

    	if ($validator->fails()) {
    		return 'Validation failed';
    	} else {
    		return 'Validation success';
    	}*/

    	$user = new User;

    	$user->name = $request->get('name');
    	$user->email = $request->get('email');
    	$user->password = Hash::make($request->get('password'));

    	$user->save();

    	return $user;
    	//return back();
    }
}
