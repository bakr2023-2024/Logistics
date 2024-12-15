<?php

namespace App\Http\Controllers;

use App\Enums\ActivityType;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Admin;
use App\Models\Customer;
use App\Providers\ActivityLogged;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $isAdmin = Route::is('admin.register');
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        $user = $isAdmin
            ? Admin::create($validated)
            : Customer::create($validated + ['address' => $validated['address']]);

        event(new ActivityLogged($isAdmin ? ActivityType::ADMIN_CREATE : ActivityType::CUSTOMER_CREATE, "$user->name created an account."));

        return redirect()->route($isAdmin ? 'admin.login' : 'login')->with('success', ($isAdmin ? 'Admin' : 'Customer') . ' created successfully!');
    }

    public function login(LoginRequest $request)
    {
        $isAdmin = Route::is('admin.login');
        $credentials = $request->validated();
        $remember = $request->boolean('remember');

        if (Auth::guard($isAdmin ? 'admin' : 'web')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $name = Auth::guard($isAdmin ? 'admin' : 'web')->user()->name;

            event(new ActivityLogged($isAdmin ? ActivityType::ADMIN_LOGIN : ActivityType::CUSTOMER_LOGIN, "$name has logged in."));

            return redirect()->route($isAdmin ? 'admin.dashboard' : 'dashboard')->with('success', 'Logged in successfully!');
        }

        return back()->withErrors(['email' => 'Invalid email or password']);
    }

    public function logout(Request $req)
    {
        $is_admin = Route::is('admin.logout');
        $username = Auth::user()->name;
        Auth::logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();
        event(new ActivityLogged($is_admin ? ActivityType::ADMIN_LOGOUT : ActivityType::CUSTOMER_LOGOUT, "$username has logged out."));
        return redirect()->route($is_admin ? 'admin.login' : 'login');
    }
}
