<?php

use App\Models\Admin;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertAuthenticatedAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertGuest;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

describe('admin', function () {
    test('can register', function () {
        $adminData = [
            'name' => 'name',
            'email' => 'name@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];
        post(route('admin.register'), $adminData)->assertRedirect(route('admin.login'));
        assertDatabaseHas('admins', [
            'email' => $adminData['email'],
        ]);
    });
    test('can login', function () {
        $admin = Admin::factory()->create(['password' => Hash::make('password')]);
        post(route('admin.login'), [
            'email' => $admin->email,
            'password' => 'password',
        ])->assertRedirect(route('admin.dashboard'));
        assertAuthenticatedAs($admin, 'admin');
    });
    test('can logout', function () {
        actingAs(Admin::factory()->create(), 'admin')->post(route('admin.logout'))->assertRedirect(route('admin.login'));
        assertGuest();
    });
});
describe('customer', function () {
    test('can register', function () {
        $customerData = [
            'name' => 'name',
            'email' => 'name@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'address' => 'address',
        ];
        post(route('register'), $customerData)->assertRedirect(route('login'));
        assertDatabaseHas('customers', [
            'email' => $customerData['email'],
        ]);
    });
    test('can login', function () {
        $customer = Customer::factory()->create(['password' => Hash::make('password')]);
        post(route('login'), [
            'email' => $customer->email,
            'password' => 'password',
        ])->assertRedirect(route('dashboard'));
        assertAuthenticatedAs($customer, 'web');
    });
    test('can logout', function () {
        actingAs(Customer::factory()->create(), 'web')->post(route('logout'))->assertRedirect(route('login'));
        assertGuest();
    });
});
