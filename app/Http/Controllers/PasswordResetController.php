<?php

namespace App\Http\Controllers;

use App\Enums\ActivityType;
use App\Jobs\SendPasswordResetEmail;
use App\Models\Admin;
use App\Models\Customer;
use App\Providers\ActivityLogged;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Str;

class PasswordResetController extends Controller
{
    public function send(Request $req)
    {
        $validated = $req->validate(['email' => 'required|email']);
        $broker = Route::is('admin.password.email') ? 'admins' : 'customers';

        SendPasswordResetEmail::dispatch($validated['email'], $broker);

        return back()->with(['success' => 'Password reset link has been sent!']);
    }


    public function reset(Request $req)
    {
        return view('shared.auth.reset-password', [
            'token' => $req->token,
        ]);
    }
    public function update(Request $req)
    {
        $req->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
        $broker = Route::is('admin.password.update') ? 'admins' : 'customers';
        $status = Password::broker($broker)->reset(
            $req->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, string $password) {
                $user->update(['password' => Hash::make($password)]);
                event(new PasswordReset($user));
            }
        );
        event(new ActivityLogged($broker === 'admins' ? ActivityType::ADMIN_PASSWORD_RESET : ActivityType::CUSTOMER_PASSWORD_RESET, ($broker === 'admins' ? 'Admin' : 'Customer' . Auth::user()->name . " have reset their password")));

        return $status === Password::PASSWORD_RESET
            ? redirect()->route($broker === 'admins' ? 'admin.login' : 'login')->with('success', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
