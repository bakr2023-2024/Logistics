@extends('layouts.layout')

@section('title', 'Shipments')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Shipments</h1>
    <div class="d-flex justify-content-between align-items-center mb-4">
        @auth('web')
            <a href="{{ route('shipments.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Create Shipment</a>
        @endauth
        @include('shared.searchBar',['resource'=>'shipments','field'=>'tracking_number'])
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>
                                @include('shared.sortBtn', ['resource' => 'shipments', 'field' => 'id'])
                            </th>
                            <th>
                                @include('shared.sortBtn', ['resource' => 'shipments', 'field' => 'tracking_number'])
                            </th>
                            <th>Customer</th>
                            <th>
                                @include('shared.sortBtn', ['resource' => 'shipments', 'field' => 'status'])
                            </th>
                            <th>
                                @include('shared.sortBtn', ['resource' => 'shipments', 'field' => 'cost'])
                            </th>
                            <th>
                                @include('shared.sortBtn', ['resource' => 'shipments', 'field' => 'tracking_number'])
                            </th>
                            <th>
                                @include('shared.sortBtn', ['resource' => 'shipments', 'field' => 'created_at'])
                            </th>
                            <th>
                                @include('shared.sortBtn', ['resource' => 'shipments', 'field' => 'updated_at'])
                            </th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($shipments as $shipment)
                            <tr>
                                <td>{{ $shipment->id }}</td>
                                <td>{{ $shipment->tracking_number }}</td>
                                <td>{{ $shipment->customer->name ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-{{ $shipment->status === 'delayed' ? 'danger' : ($shipment->status === 'delivered' ? 'success' : ($shipment->status === 'in-transit' ? 'warning' : 'secondary')) }}">
                                        {{ ucfirst($shipment->status) }}
                                    </span>
                                </td>
                                <td>${{ number_format($shipment->cost, 2) }}</td>
                                <td>{{ $shipment->customer->address }}</td>
                                <td>{{ $shipment->created_at->format('Y-m-d H:i') }}</td>
                                <td>{{ $shipment->updated_at->format('Y-m-d H:i') }}</td>
                                <td class="d-flex gap-2">
                                    @include('shared.actionBtns',['resource'=>'shipments','data'=>$shipment])
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No shipments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div>
                {{ $shipments->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
