@extends('layouts.layout')

@section('title', 'Customer Profile')

@section('content')

    <div class="container mt-4">
        <div class="card border-primary mb-3 mx-auto" style="max-width: 800px;">
            <div class="card-header text-center">
                <h3>Customer Profile: {{ $customer->name }}</h3>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $customer->name }}</p>
                <p><strong>Email:</strong> {{ $customer->email }}</p>
                <p><strong>Address:</strong> {{ $customer->address }}</p>
                <p><strong>Total Paid:</strong> ${{ number_format($customer->totalPaid(), 2) }}</p>
                <p><strong>Created At:</strong> {{ $customer->created_at->format('Y-m-d H:i') }}</p>
            </div>
            <div class="card-footer d-flex justify-content-between">
                @can('update', $customer)
                    <a href="{{ route(Auth::guard('admin')->check() ? 'admin.customers.edit' : 'customers.edit', $customer->id) }}"
                        class="btn btn-warning"><i class="bi bi-pencil"></i></a>
                @endcan
                @can('delete', $customer)
                    <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" class="d-inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')"><i
                                class="bi bi-trash"></i></button>
                    </form>
                @endcan
            </div>
        </div>

        <!-- Customer Shipments -->
        @auth('admin')
            <div class="card mt-4">
                <div class="card-header bg-secondary text-white">Customer Shipments</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Tracking Number</th>
                                    <th>Status</th>
                                    <th>Cost</th>
                                    <th>Address</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($customer->shipments as $shipment)
                                    <tr>
                                        <td>{{ $shipment->tracking_number }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $shipment->status_badge }}">{{ ucfirst($shipment->status) }}</span>
                                        </td>
                                        <td>${{ number_format($shipment->cost, 2) }}</td>
                                        <td>{{ $shipment->customer->address }}</td>
                                        <td>{{ $shipment->created_at->format('Y-m-d H:i') }}</td>
                                        <td>{{ $shipment->updated_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.shipments.show', $shipment->id) }}"
                                                class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No shipments found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endauth
    </div>
@endsection
