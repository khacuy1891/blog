<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Hash;
use Session;

use App\Models\Admin;

class AdminController extends Controller
{
    public function __construct()
    {
		
    }
	
	public function login()
	{
		$admin = session('admin');
		if ($admin) {
			return redirect()->route('admin.categories.index');
		}
		
		$message = null;
		return view('admin.login', compact('message'));
	}
	
	public function postLogin(Request $request)
	{
		$input = $request->all();
		$email = $input['email'];
		$password = $input['password'];
		$admin = Admin::where('email', '=', $email)->first();
		$message = null;
		if($admin)
		{
			if (Hash::check($password, $admin->password))
			{
				Session::put('admin', $admin);
				return redirect()->route('admin.categories.index');
			}
			$message = "Password is wrong";
		}
		else
		{
			$message = "Email not exist";
		}
		
		if($message)
		{
			return view('admin.login', compact('message'));
		}
	}
	
	public function register()
	{
		return view('admin.register');
	}
	
	public function postRegister(Request $request)
	{
		$this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|unique:t_admins,email',
			'password' => 'required|min:6|max:255',
        ]);

        $input = $request->all();
		$input['password'] = Hash::make($input['password']);
		$admin = Admin::create($input);
        return view('admin.login', compact(['message' => null, 'email' =>$admin->email]));
	}
	
	public function logout()
	{		
		Session::forget('admin');
		
		$message = null;
		return view('admin.login', compact('message'));
	}

}
