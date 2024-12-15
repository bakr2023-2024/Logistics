<?php

namespace App\Http\Controllers;

use App\Enums\ActivityType;
use App\Http\Requests\AdminUpdateRequest;
use App\Mail\TestMail;
use App\Models\Admin;
use App\Providers\ActivityLogged;
use App\Traits\SearchAndSort;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    use SearchAndSort;

    public function index(Request $request)
    {
        Gate::authorize('admin');
        $admins = $this->applySearchAndSort(Admin::query(), $request)->paginate(10);
        return view('admin.index', compact('admins'));
    }

    public function show(Admin $admin)
    {
        $this->authorize('view', $admin);

        return view('admin.show', compact('admin'));
    }

    public function edit(Admin $admin)
    {
        $this->authorize('update', $admin);

        return view('admin.edit', compact('admin'));
    }

    public function update(AdminUpdateRequest $request, Admin $admin)
    {
        $this->authorize('update', $admin);
        $validated = $request->validated();
        $validated['password'] = $validated['password'] ? Hash::make($validated['password']) : $admin->password;

        $admin->update($validated);
        event(new ActivityLogged(ActivityType::ADMIN_UPDATE, Auth::user()->name . " updated Admin $admin->name profile"));

        return redirect()
            ->route('admin.admins.show', $admin->id)
            ->with('success', 'Admin updated successfully!');
    }


    public function destroy(Request $req, Admin $admin)
    {
        $this->authorize('delete', $admin);

        $adminName = $admin->name;
        $id = $admin->id;
        $admin->delete();
        if (Auth::user()->id == $id) {
            Auth::logout();
            $req->session()->invalidate();
            $req->session()->regenerateToken();
            event(new ActivityLogged(ActivityType::CUSTOMER_DELETE, "Admin $adminName deleted themselves and logged out."));
            return redirect()->route('login')->with('success', 'Admin deleted successfully!');
        }
        event(new ActivityLogged(ActivityType::ADMIN_DELETE, Auth::user()->name . " deleted Admin $adminName"));

        return redirect()->route('admin.admins.index')->with('success', 'Admin deleted successfully!');
    }
}
