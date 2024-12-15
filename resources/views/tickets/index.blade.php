@extends('layouts.layout')

@section('title', 'My Tickets')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4">Tickets</h1>
    <div class="d-flex justify-content-between align-items-center mb-4">
        @auth('web')
            <a href="{{ route('tickets.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Create New Ticket
            </a>
        @endauth
        @include('shared.searchBar',['resource'=>"tickets",'field'=>'subject'])
    </div>

    <div class="card shadow">
        <div class="card-body">
            @if($tickets->isEmpty())
                <p class="text-center text-muted">No tickets found.</p>
            @else
                <div class="table-responsive">
                    <table class="table align-middle table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>
                                    @include('shared.sortBtn', ['resource' => 'tickets', 'field' => 'id'])
                                </th>
                                <th>
                                    @include('shared.sortBtn', ['resource' => 'tickets', 'field' => 'subject'])
                                </th>
                                <th>
                                    @include('shared.sortBtn', ['resource' => 'tickets', 'field' => 'status'])
                                </th>
                                <th>Customer</th>
                                <th>
                                    @include('shared.sortBtn', ['resource' => 'tickets', 'field' => 'created_at'])
                                </th>
                                <th>
                                    @include('shared.sortBtn', ['resource' => 'tickets', 'field' => 'updated_at'])
                                </th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tickets as $ticket)
                                <tr>
                                    <td>{{ $ticket->id }}</td>
                                    <td>{{ $ticket->subject }}</td>
                                    <td>
                                        <span class="badge {{ $ticket->status == 'pending' ? 'bg-warning' : 'bg-success' }}">
                                            {{ ucfirst($ticket->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $ticket->customer->name }}</td>
                                    <td>{{ $ticket->created_at->format('Y-m-d H:i') }}</td>
                                    <td>{{ $ticket->updated_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        @include('shared.actionBtns',['resource'=>'tickets','data'=>$ticket])
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $tickets->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
