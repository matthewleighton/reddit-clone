<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Hash;
use Auth;

class UsersController extends Controller
{
    public function create()
    {
    	if (Auth::user()) {
            return redirect()->action('SubredditsController@home');
        }    	

    	return view('users.create');
    }

    public function save(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required|unique:users',
    		'password' => 'required|min:5|confirmed',
    		'password_confirmation' => 'required|min:5',
    		'email' => 'required|email|unique:users'
    	]);

    	$user = new User;

    	$user->name = $request->get('name');
    	$user->email = $request->get('email');
    	$user->password = Hash::make($request->get('password'));

    	$user->save();

    	if (Auth::attempt(['name' => $request->get('name'), 'password' => $request->get('password')])) {
    		return redirect()->action('SubredditsController@home');
    	} else {
    		return back();
    	}
    }

    public function loginForm()
    {
    	if (Auth::user()) {
            return redirect()->action('SubredditsController@home');
        }
    	
    	return view('users.loginForm');
    }

    public function login(Request $request)
    {    	
    	$name = $request->get('name');

    	if (Auth::attempt(['name' => $name, 'password' => $request->get('password')])) {
    		return redirect()->action('SubredditsController@all');
    	} else {
    		return back()->with('name', $name)->with('error', "The password you've entered is inncorrect.");
    	}
    }

    public function logout()
    {
    	Auth::logout();
    	return redirect()->action('SubredditsController@home');
    }
}
