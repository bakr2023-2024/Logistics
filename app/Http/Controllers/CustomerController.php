<?php

namespace App\Http\Controllers;

use App\Enums\ActivityType;
use App\Http\Requests\CustomerUpdateRequest;
use App\Models\Customer;
use App\Providers\ActivityLogged;
use App\Traits\SearchAndSort;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    use SearchAndSort;

    public function index(Request $request)
    {
        Gate::authorize('admin');
        $customers = $this->applySearchAndSort(Customer::query(), $request)->paginate(10);

        return view('customers.index', compact('customers'));
    }
    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        // Ensure the user can view the customer
        $this->authorize('view', $customer);
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        // Ensure the user can edit their own customer profile
        $this->authorize('update', $customer);

        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerUpdateRequest $request, Customer $customer)
    {
        $this->authorize('update', $customer);
        $validated = $request->validated();
        $validated['password'] = $validated['password'] ? Hash::make($validated['password']) : $customer->password;

        $customer->update($validated);
        event(new ActivityLogged(ActivityType::CUSTOMER_UPDATE, Auth::user()->name . " updated Customer $customer->name profile"));

        return redirect()
            ->route((Auth::guard('admin')->check() ? 'admin.' : '') . 'customers.show', $customer->id)
            ->with('success', 'Customer updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $req, Customer $customer)
    {
        // Ensure the user can delete their own profile
        $this->authorize('delete', $customer);
        $id = $customer->id;
        $customer->delete();
        if (Auth::guard('web')->check()) {
            if (Auth::user()->id == $id) {
                Auth::logout();
                $req->session()->invalidate();
                $req->session()->regenerateToken();
                event(new ActivityLogged(ActivityType::CUSTOMER_DELETE, "Customer $customer->name deleted themselves and logged out."));
                return redirect()->route('login')->with('success', 'Customer deleted successfully!');
            }
        }
        $adminname = Auth::user()->name;
        event(new ActivityLogged(ActivityType::CUSTOMER_DELETE, "$adminname has deleted Customer $customer->name."));
        return redirect()->route('admin.customers.index')->with('success', 'Customer deleted successfully!');
    }
}
