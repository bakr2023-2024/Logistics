@extends('layouts.layout')

@section('title', 'Create New Ticket')

@section('content')
<div class="container my-5">
    <div class="card border-primary shadow-lg mx-auto" style="max-width: 800px;">
        <div class="card-header text-center bg-primary text-white">
            <h2>Create a New Ticket</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('tickets.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" id="subject" name="subject" class="form-control" placeholder="Enter ticket subject" required>
                </div>

                <div class="mb-4">
                    <label for="content" class="form-label">Content</label>
                    <textarea id="content" name="content" class="form-control" rows="5" placeholder="Describe the issue" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-plus-circle"></i> Submit
                </button>
            </form>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route(Auth::guard('admin')->check() ? 'admin.tickets.index' : 'tickets.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>
</div>
@endsection
