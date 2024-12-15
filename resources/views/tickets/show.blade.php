@extends('layouts.layout')

@section('title', 'Ticket Details')

@section('content')
    <div class="container my-5">
        <div class="card border-primary shadow-lg mx-auto" style="max-width: 800px;">
            <div class="card-header text-center bg-primary text-white">
                <h3>{{ $ticket->subject }}</h3>
            </div>
            <div class="card-body">
                <p><strong>Status:</strong>
                    <span class="badge {{ $ticket->status == 'pending' ? 'bg-warning' : 'bg-success' }}">
                        {{ ucfirst($ticket->status) }}
                    </span>
                </p>
                <p><strong>Content:</strong></p>
                <p>{{ $ticket->content }}</p>
            </div>
            <div class="card-footer text-muted d-flex justify-content-between">
                <span><strong>Created At:</strong> {{ $ticket->created_at->format('Y-m-d H:i') }}</span>
                <span><strong>Updated At:</strong> {{ $ticket->updated_at->format('Y-m-d H:i') }}</span>
            </div>
        </div>

        <div class="text-center mt-4">
            @can('update', $ticket)
                <a href="{{ route('admin.tickets.edit', $ticket->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i>
                </a>
            @endcan
            @can('delete', $ticket)
                <form action="{{ route('admin.tickets.destroy', $ticket->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            @endcan
            <a href="{{ route(Auth::guard('admin')->check() ? 'admin.tickets.index' : 'tickets.index') }}"
                class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i>
            </a>
        </div>
    </div>
@endsection
