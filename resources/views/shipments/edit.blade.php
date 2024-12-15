@extends('layouts.layout')

@section('title', 'Edit Shipment')

@section('content')
<div class="container mt-4">
    <div class="card border-success mx-auto" style="max-width: 800px;">
        <div class="card-header text-center">
            <h2>Update Shipment: {{ $shipment->tracking_number }}</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.shipments.update', $shipment->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="new" {{ $shipment->status === 'new' ? 'selected' : '' }}>New</option>
                        <option value="in-transit" {{ $shipment->status === 'in-transit' ? 'selected' : '' }}>In-Transit</option>
                        <option value="delivered" {{ $shipment->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="delayed" {{ $shipment->status === 'delayed' ? 'selected' : '' }}>Delayed</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success mt-4 w-100">Update</button>
            </form>
        </div>
    </div>
    <div class="text-center mt-3">
        <a href="{{ route(Auth::guard('admin')->check() ? 'admin.shipments.show' : 'shipments.show',$shipment->id) }}" class="btn btn-secondary">Back to Shipment</a>
        <a href="{{ route(Auth::guard('admin')->check() ? 'admin.shipments.index' : 'shipments.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
</div>
@endsection
