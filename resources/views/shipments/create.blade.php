@extends('layouts.layout')

@section('title', 'Create Shipment')

@section('content')
<div class="container mt-4">
    <div class="card border-success mx-auto" style="max-width: 800px;">
        <div class="card-header text-center">
            <h2>Create Shipment</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('shipments.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="cost">Cost</label>
                    <input type="number" id="cost" name="cost" class="form-control" step="0.01" placeholder="Enter cost" required>
                </div>
                <button type="submit" class="btn btn-success mt-4 w-100">Create Shipment</button>
            </form>
        </div>
    </div>
    <div class="text-center mt-3">
        <a href="{{ route(Auth::guard('admin')->check() ? 'admin.shipments.index' : 'shipments.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
</div>
@endsection
