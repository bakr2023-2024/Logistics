@extends('layouts.layout')

@section('title', 'Update Ticket')

@section('content')
<div class="container my-5">
    <div class="card border-success shadow-lg mx-auto" style="max-width: 800px;">
        <div class="card-header text-center bg-success text-white">
            <h2>Update Ticket</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.tickets.update', $ticket->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" id="subject" class="form-control" value="{{ $ticket->subject }}" disabled>
                </div>

                <div class="mb-4">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select" required>
                        <option value="pending" {{ $ticket->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success w-100">
                    <i class="bi bi-check-circle"></i> Update
                </button>
            </form>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route(Auth::guard('admin')->check() ? 'admin.tickets.show' : 'tickets.show',$ticket->id) }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Ticket
        </a>
        <a href="{{ route(Auth::guard('admin')->check() ? 'admin.tickets.index' : 'tickets.index') }}" class="btn btn-secondary">
            <i class="bi bi-list"></i> Back to List
        </a>
    </div>
</div>
@endsection
