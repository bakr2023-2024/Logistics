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
    test('can view all admins', function () {
        $admin = Admin::factory()->create();
        Admin::factory(5)->create();
        actingAs($admin, 'admin')->get(route('admin.admins.index'))->assertOk();
    });
    test('can view any admin, given id', function () {
        $admin = Admin::factory()->create();
        $user =  Admin::factory()->create();
        actingAs($admin, 'admin')
            ->get(route('admin.admins.show', ['admin' => $user->id]))
            ->assertOk();
    });
    test('cannot view an admin with invalid id', function () {
        $admin = Admin::factory()->create();
        actingAs($admin, 'admin')
            ->get(route('admin.admins.show', ['admin' => -1]))
            ->assertNotFound();
    });
    test('can update any admin, given id', function () {
        $admin = Admin::factory()->create();
        $user =  Admin::factory()->create();
        actingAs($admin, 'admin')
            ->get(route('admin.admins.edit', ['admin' => $user->id]))
            ->assertOk();
        actingAs($admin, 'admin')
            ->put(route('admin.admins.update', ['admin' => $user->id, 'name' => 'John Doe', 'email' => $user->email, 'password' => '']))
            ->assertRedirect(route('admin.admins.show', ['admin' => $user->id]));
        assertDatabaseHas('admins', ['id' => $user->id, 'name' => 'John Doe']);
    });
    test('cannot update an admin with invalid id', function () {
        $admin = Admin::factory()->create();
        actingAs($admin, 'admin')
            ->get(route('admin.admins.edit', ['admin' => -1]))
            ->assertNotFound();
    });
    test('cannot update an admin with an invalid field', function () {
        $admin = Admin::factory()->create();
        $user =  Admin::factory()->create();
        actingAs($admin, 'admin')
            ->get(route('admin.admins.edit', ['admin' => $user->id]))
            ->assertOk();
        actingAs($admin, 'admin')
            ->put(route('admin.admins.update', ['admin' => $user->id, 'name' => 'John Doe', 'email' => 'John Doe', 'password' => '']))
            ->assertRedirect(route('admin.admins.edit', ['admin' => $user->id]));
        assertDatabaseHas('admins', ['id' => $user->id, 'email' => $user->email]);
    });
    test('can delete any admin, given id', function () {
        $admin = Admin::factory()->create();
        $user = Admin::factory()->create();
        actingAs($admin, 'admin')
            ->delete(route('admin.admins.destroy', ['admin' => $user->id]))
            ->assertRedirect(route('admin.admins.index'));
        assertDatabaseMissing('admins', ['id' => $user->id]);
    });
    test('cannot delete an admin with invalid id', function () {
        $admin = Admin::factory()->create();
        actingAs($admin, 'admin')
            ->delete(route('admin.admins.destroy', ['admin' => -1]))
            ->assertNotFound();
    });
});

describe('customers', function () {
    test('cannot view all admins', function () {
        $customer = Customer::factory()->create();

        actingAs($customer, 'web')
            ->get(route('admin.admins.index'))
            ->assertRedirect(route('login'));
    });

    test('cannot view a specific admin', function () {
        $customer = Customer::factory()->create();
        $admin = Admin::factory()->create();

        actingAs($customer, 'web')
            ->get(route('admin.admins.show', ['admin' => $admin->id]))
            ->assertRedirect(route('login'));
    });

    test('cannot update an admin', function () {
        $customer = Customer::factory()->create();
        $admin = Admin::factory()->create();

        actingAs($customer, 'web')
            ->put(route('admin.admins.update', ['admin' => $admin->id]), [
                'name' => 'Hacker',
                'email' => 'hacker@example.com',
                'password' => 'password123',
            ])
            ->assertRedirect(route('login'));


        assertDatabaseMissing('admins', [
            'id' => $admin->id,
            'name' => 'Hacker',
            'email' => 'hacker@example.com',
        ]);
    });

    test('cannot delete an admin', function () {
        $customer = Customer::factory()->create();
        $admin = Admin::factory()->create();

        actingAs($customer, 'web')
            ->delete(route('admin.admins.destroy', ['admin' => $admin->id]))
            ->assertRedirect(route('login'));

        assertDatabaseHas('admins', ['id' => $admin->id]);
    });
});
