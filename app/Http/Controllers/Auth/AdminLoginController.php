<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Route;

class AdminLoginController extends Controller {

    use AuthenticatesUsers;

    protected $guard = 'admin';

    public function __construct() {
        $this->middleware('guest:admin', ['except' => ['logout']]);
    }

    public function showLoginForm() {
        return view('admin.bootstrap.admin-login');
    }

    public function login(Request $request) {
    
        // Validate the form data
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|min:6',
        ]);
        
        // Attempt to log the user in
        if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password, 'account_type_id' => 1], $request->remember)) {
            // if successful, then redirect to their intended location
            return redirect('/admin/dashboard');
        }
        
        // if unsuccessful, then redirect back to the login with the form data
        return redirect()->back()->withInput($request->only('email', 'remember'))->with('error','You have not admin access');
    }

    public function logout() {
        Auth::guard('admin')->logout();
        return redirect()->guest(route('admin.login'));
    }
}
