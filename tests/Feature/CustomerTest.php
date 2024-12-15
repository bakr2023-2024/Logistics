<?php

use App\Models\Admin;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

uses(RefreshDatabase::class);
describe('admin', function () {
    test('can view all customers', function () {
        $admin = Admin::factory()->create();
        Customer::factory(5)->create();
        actingAs($admin, 'admin')->get(route('admin.customers.index'))->assertOk();
    });

    test('can view any customer by id', function () {
        $admin = Admin::factory()->create();
        $customer = Customer::factory()->create();

        actingAs($admin, 'admin')
            ->get(route('admin.customers.show', ['customer' => $customer->id]))
            ->assertOk();
    });

    test('can update any customer', function () {
        $admin = Admin::factory()->create();
        $customer = Customer::factory()->create();

        actingAs($admin, 'admin')
            ->put(route('admin.customers.update', ['customer' => $customer->id]), [
                'name' => 'Updated Name',
                'email' => $customer->email,
                'address' => $customer->address,
                'password' => '',
            ])
            ->assertRedirect(route('admin.customers.show', ['customer' => $customer->id]));

        assertDatabaseHas('customers', [
            'id' => $customer->id,
            'name' => 'Updated Name',
        ]);
    });

    test('can delete any customer', function () {
        $admin = Admin::factory()->create();
        $customer = Customer::factory()->create();

        actingAs($admin, 'admin')
            ->delete(route('admin.customers.destroy', ['customer' => $customer->id]))
            ->assertRedirect(route('admin.customers.index'));

        assertDatabaseMissing('customers', [
            'id' => $customer->id,
        ]);
    });
});
describe('customer', function () {
    test('can view their own profile', function () {
        $customer = Customer::factory()->create();

        actingAs($customer, 'web')
            ->get(route('customers.show', ['customer' => $customer->id]))
            ->assertOk();
    });

    test("cannot view another customer's profile", function () {
        $customer = Customer::factory()->create();
        $otherCustomer = Customer::factory()->create();

        actingAs($customer, 'web')
            ->get(route('customers.show', ['customer' => $otherCustomer->id]))
            ->assertForbidden();
    });

    test('can update their own profile', function () {
        $customer = Customer::factory()->create();

        actingAs($customer, 'web')
            ->put(route('customers.update', ['customer' => $customer->id]), [
                'name' => 'Self Updated Name',
                'email' => $customer->email,
                'address' => $customer->address,
                'password' => '',
            ])
            ->assertRedirect(route('customers.show', ['customer' => $customer->id]));

        assertDatabaseHas('customers', [
            'id' => $customer->id,
            'name' => 'Self Updated Name',
        ]);
    });

    test("cannot update another customer's profile", function () {
        $customer = Customer::factory()->create();
        $otherCustomer = Customer::factory()->create();

        actingAs($customer, 'web')
            ->put(route('customers.update', ['customer' => $otherCustomer->id]), [
                'name' => 'Hacked Name',
                'email' => 'hacker@example.com',
                'address' => $otherCustomer->address,
                'password' => '',
            ])
            ->assertForbidden();

        assertDatabaseMissing('customers', [
            'id' => $otherCustomer->id,
            'name' => 'Hacked Name',
        ]);
    });

    test('can delete their own account', function () {
        $customer = Customer::factory()->create();

        actingAs($customer, 'web')
            ->delete(route('customers.destroy', ['customer' => $customer->id]))
            ->assertRedirect(route('login'));

        assertDatabaseMissing('customers', [
            'id' => $customer->id,
        ]);
    });

    test("cannot delete another customer's account", function () {
        $customer = Customer::factory()->create();
        $otherCustomer = Customer::factory()->create();

        actingAs($customer, 'web')
            ->delete(route('customers.destroy', ['customer' => $otherCustomer->id]))
            ->assertForbidden();

        assertDatabaseHas('customers', [
            'id' => $otherCustomer->id,
        ]);
    });
});
