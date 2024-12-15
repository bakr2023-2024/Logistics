<?php

use App\Models\Admin;
use App\Models\Customer;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

uses(RefreshDatabase::class);

describe('admin', function () {
    test('can view all tickets', function () {
        $admin = Admin::factory()->create();
        Customer::factory()->hasTickets(3)->create();

        actingAs($admin, 'admin')->get(route('admin.tickets.index'))->assertOk();
    });

    test('can view any ticket by id', function () {
        $admin = Admin::factory()->create();
        $ticket = Ticket::factory()->for(Customer::factory()->create())->create();

        actingAs($admin, 'admin')
            ->get(route('admin.tickets.show', ['ticket' => $ticket->id]))
            ->assertOk();
    });

    test('can update any ticket', function () {
        $admin = Admin::factory()->create();
        $ticket = Ticket::factory()->for(Customer::factory()->create())->create();

        actingAs($admin, 'admin')
            ->put(route('admin.tickets.update', ['ticket' => $ticket->id]), [
                'status' => 'resolved',
            ])
            ->assertRedirect(route('admin.tickets.show', ['ticket' => $ticket->id]));

        assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'status' => 'resolved',
        ]);
    });

    test('can delete any ticket', function () {
        $admin = Admin::factory()->create();
        $ticket = Ticket::factory()->for(Customer::factory()->create())->create();

        actingAs($admin, 'admin')
            ->delete(route('admin.tickets.destroy', ['ticket' => $ticket->id]))
            ->assertRedirect(route('admin.tickets.index'));

        assertDatabaseMissing('tickets', [
            'id' => $ticket->id,
        ]);
    });
});

describe('customer', function () {
    test('can create a ticket', function () {
        $customer = Customer::factory()->create();

        actingAs($customer, 'web')
            ->post(route('tickets.store'), [
                'subject' => 'Need support',
                'content' => 'I have an issue with my shipment.',
            ])
            ->assertRedirect(route('tickets.index'));

        assertDatabaseHas('tickets', [
            'customer_id' => $customer->id,
            'subject' => 'Need support',
            'content' => 'I have an issue with my shipment.',
        ]);
    });

    test('can view all of their tickets', function () {
        $customer = Customer::factory()->hasTickets(1)->create();

        actingAs($customer, 'web')->get(route('tickets.index'))->assertOk();
    });
    test('cannot update any ticket', function () {
        $customer = Customer::factory()->create();
        $ticket = Ticket::factory()->for($customer)->create();

        actingAs($customer, 'web')
            ->put(route('admin.tickets.update', ['ticket' => $ticket->id]), [
                'status' => 'resolved',
            ])
            ->assertRedirect(route('login'));

        assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'status' => $ticket->status,
        ]);
    });
    test('cannot delete any ticket', function () {
        $customer = Customer::factory()->create();
        $ticket = Ticket::factory()->for($customer)->create();

        actingAs($customer, 'web')
            ->delete(route('admin.tickets.destroy', ['ticket' => $ticket->id]))
            ->assertRedirect(route('login'));

        assertDatabaseHas('tickets', [
            'id' => $ticket->id,
        ]);
    });

    test("cannot view another customer's ticket", function () {
        $customer = Customer::factory()->create();
        $otherCustomer = Customer::factory()->create();
        $ticket = Ticket::factory()->for($otherCustomer)->create();

        actingAs($customer, 'web')
            ->get(route('tickets.show', ['ticket' => $ticket->id]))
            ->assertForbidden();
    });
});
