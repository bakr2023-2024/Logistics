@extends('layouts.layout')

@section('content')
    <div class="container">
        <h1 class="my-4">Admin Details</h1>
        <div class="card">
            <div class="card-body">
                <p><strong>ID:</strong> {{ $admin->id }}</p>
                <p><strong>Name:</strong> {{ $admin->name }}</p>
                <p><strong>Email:</strong> {{ $admin->email }}</p>
                <p><strong>Created At:</strong> {{ $admin->created_at->format('Y-m-d H:i') }}</p>
            </div>
        </div>
        <div class="mt-3">
            <a href="{{ route('admin.admins.edit', $admin->id) }}" class="btn btn-warning"><i class="bi bi-pencil"></i></a>
            <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST" class="d-inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')"><i
                        class="bi bi-trash"></i></button>
            </form>
            <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">Back to list</a>
        </div>
    </div>
@endsection
