<?php

use App\Models\Admin;
use App\Models\Customer;
use App\Models\Shipment;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

uses(RefreshDatabase::class);

describe('admin', function () {
    test('can view all shipments', function () {
        $admin = Admin::factory()->create();
        Customer::factory()->hasShipments(3)->create();
        actingAs($admin, 'admin')->get(route('admin.shipments.index'))->assertOk();
    });

    test('can view any shipment by id', function () {
        $admin = Admin::factory()->create();
        $shipment = Shipment::factory()->for(Customer::factory()->create())->create();

        actingAs($admin, 'admin')
            ->get(route('admin.shipments.show', ['shipment' => $shipment->id]))
            ->assertOk();
    });
    test('can update any shipment', function () {
        $admin = Admin::factory()->create();
        $shipment = Shipment::factory()->for(Customer::factory()->create())->create();
        actingAs($admin, 'admin')
            ->put(route('admin.shipments.update', ['shipment' => $shipment->id]), [
                'status' => 'delivered',
            ])
            ->assertRedirect(route('admin.shipments.show', ['shipment' => $shipment->id]));

        assertDatabaseHas('shipments', [
            'id' => $shipment->id,
            'status' => 'delivered',
        ]);
    });

    test('can delete any shipment', function () {
        $admin = Admin::factory()->create();
        $shipment = Shipment::factory()->for(Customer::factory()->create())->create();

        actingAs($admin, 'admin')
            ->delete(route('admin.shipments.destroy', ['shipment' => $shipment->id]))
            ->assertRedirect(route('admin.shipments.index'));

        assertDatabaseMissing('shipments', [
            'id' => $shipment->id,
        ]);
    });
});

describe('customer', function () {
    test('can create a shipment', function () {
        $customer = Customer::factory()->create();

        actingAs($customer, 'web')
            ->post(route('shipments.store'), [
                'cost' => 20,
            ])
            ->assertRedirect(route('shipments.index'));

        assertDatabaseHas('shipments', [
            'customer_id' => $customer->id,
            'cost' => 20,
        ]);
    });

    test('can view all of their shipments', function () {
        $customer = Customer::factory()->hasShipments(1)->create();

        actingAs($customer, 'web')->get(route('shipments.index'))->assertOk();
    });

    test('can view any of their shipments', function () {
        $customer = Customer::factory()->hasShipments(1)->create();
        $shipment = Shipment::factory()->for($customer)->create();

        actingAs($customer, 'web')
            ->get(route('shipments.show', ['shipment' => $shipment->id]))
            ->assertOk();
    });

    test("cannot view another customer's shipment", function () {
        $customer = Customer::factory()->create();
        $otherCustomer = Customer::factory()->create();
        $shipment = Shipment::factory()->for($otherCustomer)->create();

        actingAs($customer, 'web')
            ->get(route('shipments.show', ['shipment' => $shipment->id]))
            ->assertForbidden();
    });

    test("cannot update another customer's shipment", function () {
        $customer = Customer::factory()->create();
        $otherCustomer = Customer::factory()->create();
        $shipment = Shipment::factory()->for($otherCustomer)->create();

        actingAs($customer, 'web')
            ->put(route('admin.shipments.update', ['shipment' => $shipment->id]), [
                'status' => 'delivered',
            ])
            ->assertRedirect(route('login'));

        assertDatabaseHas('shipments', [
            'id' => $shipment->id,
            'status' => $shipment->status,
        ]);
    });

    test("cannot delete another customer's shipment", function () {
        $customer = Customer::factory()->create();
        $otherCustomer = Customer::factory()->create();
        $shipment = Shipment::factory()->for($otherCustomer)->create();

        actingAs($customer, 'web')
            ->delete(route('admin.shipments.destroy', ['shipment' => $shipment->id]))
            ->assertRedirect(route('login'));

        assertDatabaseHas('shipments', [
            'id' => $shipment->id,
        ]);
    });
});
