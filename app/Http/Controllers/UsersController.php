<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Hash;
use Auth;

class UsersController extends Controller
{
    public function show()
    {
        return view('users.show');
    }

    public function create(Request $request)
    {
    	if (Auth::user()) {
            return redirect()->action('SubredditsController@home');
        }    	

    	return view('users.create')->with('redirect', $request->get('redirect'));
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

        $remember = $request->get('remember');

    	if (Auth::attempt(['name' => $request->get('name'), 'password' => $request->get('password')], $remember)) {
    		$redirect = $request->get('redirect');
            return $redirect ? redirect($redirect) : redirect()->action('SubredditsController@all');
    	} else {
    		return back();
    	}
    }

    public function loginForm(Request $request)
    {
    	if (Auth::user()) {
            return redirect()->action('SubredditsController@all');
        }
    	
    	return view('users.loginForm')->with('redirect', $request->query('redirect'));
    }

    public function login(Request $request)
    {    	
    	$name = $request->get('name');
        $remember = $request->get('remember');
        $redirect = $request->get('redirect');

    	if (Auth::attempt(['name' => $name, 'password' => $request->get('password')], $remember)) {
    		return $redirect ? redirect($redirect) : redirect()->action('SubredditsController@all');
    	} else {
    		return back()->with('name', $name)->with('error', "The password you've entered is inncorrect.");
    	}
    }

    public function logout()
    {
    	Auth::logout();
    	return redirect()->action('SubredditsController@all');
    }

    // Confirm whether the user is logged in. For use in responding to AJAX request.
    public function confirm()
    {
        return Auth::user() ? '1' : '';
    }
}
