@extends('layouts.layout')

@section('title', 'Shipment Details')

@section('content')
    <div class="container mt-4">
        <div class="card border-info mb-3 mx-auto" style="max-width: 800px;">
            <div class="card-header text-center">
                <h3>Shipment #{{ $shipment->tracking_number }}</h3>
            </div>
            <div class="card-body">
                <p><strong>Customer:</strong> {{ $shipment->customer->name ?? 'N/A' }}</p>
                <p><strong>Status:</strong> <span
                        class="badge bg-{{ $shipment->status === 'delayed' ? 'danger' : ($shipment->status === 'delivered' ? 'success' : ($shipment->status === 'in-transit' ? 'warning' : 'secondary')) }}">{{ ucfirst($shipment->status) }}</span>
                </p>
                <p><strong>Cost:</strong> ${{ number_format($shipment->cost, 2) }}</p>
                <p><strong>Address:</strong> {{ $shipment->customer->address }}</p>
            </div>
            <div class="card-footer text-muted d-flex justify-content-between">
                <span><strong>Created At:</strong> {{ $shipment->created_at->format('Y-m-d H:i') }}</span>
                <span><strong>Updated At:</strong> {{ $shipment->updated_at->format('Y-m-d H:i') }}</span>
            </div>
        </div>

        <div class="text-center">
            @can('update', $shipment)
                <a href="{{ route('admin.shipments.edit', $shipment->id) }}" class="btn btn-warning"><i
                        class="bi bi-pencil"></i></a>
            @endcan
            @can('delete', $shipment)
                <form action="{{ route('admin.shipments.destroy', $shipment->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')"><i
                            class="bi bi-trash"></i></button>
                </form>
            @endcan
            <a href="{{ route(Auth::guard('admin')->check() ? 'admin.shipments.index' : 'shipments.index') }}"
                class="btn btn-secondary"><i class="bi bi-arrow-left"></i></a>
        </div>
    </div>
@endsection
