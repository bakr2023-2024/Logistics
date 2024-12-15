<?php

use App\Enums\ActivityType;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\Log;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

describe('admin', function () {
    test('can view all logs', function () {
        $admin = Admin::factory()->create();
        Log::factory(4)->create();
        actingAs($admin, 'admin')->get(route('admin.logs.index'))->assertOk();
    });

    test('can delete any log', function () {
        $admin = Admin::factory()->create();
        Log::factory(1)->create(['activity_type' => ActivityType::ADMIN_CREATE]);
        $log = Log::all()->first();
        actingAs($admin, 'admin')
            ->delete(route('admin.logs.destroy', ['log' => $log->id]))
            ->assertRedirect(route('admin.logs.index'));

        assertDatabaseMissing('logs', [
            'activity_type' => ActivityType::ADMIN_CREATE,
        ]);
    });
});

describe('customer', function () {
    test('cannot view logs', function () {
        $customer = Customer::factory()->create();
        Log::factory(4)->create();
        actingAs($customer, 'web')->get(route('admin.logs.index'))->assertRedirect(route('login'));
    });

    test('cannot delete logs', function () {
        $customer = Customer::factory()->create();
        Log::factory(1)->create(['activity_type' => ActivityType::ADMIN_CREATE]);
        $log = Log::all()->first();

        actingAs($customer, 'web')
            ->delete(route('admin.logs.destroy', ['log' => $log->id]))
            ->assertRedirect(route('login'));

        assertDatabaseHas('logs', [
            'activity_type' => ActivityType::ADMIN_CREATE,
        ]);
    });
});

describe('log creation', function () {
    test('creates a log when an admin registers', function () {
        $adminData = [
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $this->post(route('admin.register'), $adminData)->assertRedirect(route('admin.login'));

        assertDatabaseHas('logs', [
            'activity_type' => ActivityType::ADMIN_CREATE->value,
            'description' => $adminData['name'] . ' created an account.',
        ]);
    });

    test('creates a log when a customer registers', function () {
        $customerData = [
            'name' => 'Customer User',
            'email' => 'customer@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'address' => '123 Street',
        ];

        $this->post(route('register'), $customerData)->assertRedirect(route('login'));

        assertDatabaseHas('logs', [
            'activity_type' => ActivityType::CUSTOMER_CREATE->value,
            'description' => $customerData['name'] . ' created an account.',
        ]);
    });

    test('creates a log when an admin logs in', function () {
        $admin = Admin::factory()->create(['password' => Hash::make('password')]);
        post(route('admin.login'), [
            'email' => $admin->email,
            'password' => 'password',
        ])->assertRedirect(route('admin.dashboard'));

        assertDatabaseHas('logs', [
            'activity_type' => ActivityType::ADMIN_LOGIN->value,
            'description' => $admin['name'] . ' has logged in.',
        ]);
    });

    test('creates a log when a customer logs in', function () {
        $customer = Customer::factory()->create(['password' => bcrypt('password')]);

        post(route('login'), [
            'email' => $customer->email,
            'password' => 'password',
        ])->assertRedirect(route('dashboard'));

        assertDatabaseHas('logs', [
            'activity_type' => ActivityType::CUSTOMER_LOGIN->value,
            'description' => "$customer->name has logged in.",
        ]);
    });

    test('creates a log when an admin logs out', function () {
        $admin = Admin::factory()->create();
        actingAs($admin, 'admin')->post(route('admin.logout'))->assertRedirect(route('admin.login'));

        assertDatabaseHas('logs', [
            'activity_type' => ActivityType::ADMIN_LOGOUT->value,
            'description' => "$admin->name has logged out.",
        ]);
    });

    test('creates a log when a customer logs out', function () {
        $customer = Customer::factory()->create();
        actingAs($customer, 'web')->post(route('logout'))->assertRedirect(route('login'));

        assertDatabaseHas('logs', [
            'activity_type' => ActivityType::CUSTOMER_LOGOUT->value,
            'description' => "$customer->name has logged out.",
        ]);
    });
});
