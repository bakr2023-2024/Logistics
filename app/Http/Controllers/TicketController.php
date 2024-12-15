<?php

namespace App\Http\Controllers;

use App\Enums\ActivityType;
use App\Http\Requests\TicketStoreRequest;
use App\Http\Requests\TicketUpdateRequest;
use App\Models\Ticket;
use App\Providers\ActivityLogged;
use App\Traits\SearchAndSort;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    use SearchAndSort;
    public function index(Request $request)
    {
        $query = Auth::guard('admin') ? Ticket::query() : Auth::user()->tickets();
        $tickets = $this->applySearchAndSort(Ticket::query(), $request)->paginate(10);

        return view('tickets.index', compact('tickets'));
    }
    public function create()
    {
        $this->authorize('create', Ticket::class);

        return view('tickets.create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(TicketStoreRequest $request)
    {
        $this->authorize('create', Ticket::class);

        $validated = $request->validated();
        $validated['customer_id'] = Auth::user()->id;

        $ticket = Ticket::create($validated);

        event(new ActivityLogged(ActivityType::TICKET_CREATE, Auth::user()->name . " created ticket $ticket->id"));

        return redirect()->route('tickets.index')->with('success', 'Ticket created successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        // Ensure the user can view the ticket
        $this->authorize('view', $ticket);

        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        // Ensure the user can edit the ticket (admin only for replying)
        $this->authorize('update', $ticket);

        return view('tickets.edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TicketUpdateRequest $request, Ticket $ticket)
    {
        $this->authorize('update', $ticket);

        $validated = $request->validated();

        $ticket->update($validated);

        event(new ActivityLogged(ActivityType::TICKET_UPDATE, Auth::user()->name . " updated ticket $ticket->id ($ticket->status)"));

        return redirect()->route('admin.tickets.show', $ticket->id)->with('success', 'Ticket updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        // Ensure the user can delete the ticket (admin or the customer)
        $this->authorize('delete', $ticket);
        $ticket->delete();
        event(new ActivityLogged(ActivityType::TICKET_DELETE, Auth::user()->name . " deleted ticket $ticket->id"));
        return redirect()->route('admin.tickets.index')->with('success', 'Ticket deleted successfully!');
    }
}
