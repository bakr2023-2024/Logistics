<?php

use App\Models\Admin;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

describe('admin', function () {
    test('can access admin routes', function () {
        $admin = Admin::factory()->create();
        actingAs($admin, 'admin')
            ->get(route('admin.dashboard'))
            ->assertOk();
    });
    test('cannot access customer routes', function () {
        $admin = Admin::factory()->create();

        actingAs($admin, 'admin')
            ->get(route('dashboard'))
            ->assertRedirect(route('login'));
    });
    test('cannot access login or register once authenticated', function () {
        $admin = Admin::factory()->create();

        actingAs($admin, 'admin')
            ->get(route('admin.login'))
            ->assertRedirect(route('admin.dashboard'));
        actingAs($admin, 'admin')
            ->get(route('admin.register'))
            ->assertRedirect(route('admin.dashboard'));
    });
});

describe('customer', function () {
    test('can access customer routes', function () {
        $customer = Customer::factory()->create();

        actingAs($customer, 'web')
            ->get(route('dashboard'))
            ->assertOk();
    });
    test('cannot access admin routes', function () {
        $customer = Customer::factory()->create();

        actingAs($customer, 'web')
            ->get(route('admin.dashboard'))
            ->assertRedirect(route('login'));
    });
    test('cannot access login or register once authenticated', function () {
        $customer = Customer::factory()->create();

        actingAs($customer, 'web')
            ->get(route('login'))
            ->assertRedirect(route('dashboard'));
        actingAs($customer, 'web')
            ->get(route('register'))
            ->assertRedirect(route('dashboard'));
    });
});
describe('guest', function () {
    test('cannot access admin routes', function () {
        get(route('admin.dashboard'))
            ->assertRedirect(route('login'));
    });
    test('guest cannot access customer routes', function () {
        get(route('dashboard'))
            ->assertRedirect(route('login'));
    });
});
