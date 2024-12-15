@extends('layouts.layout')

@section('title', 'All Customers')

@section('content')
    <div class="container mt-5 w-100">
        <h1 class="text-center">All Customers</h1>
        <div class="d-flex justify-content-between align-items-center mb-4">
            @include('shared.searchBar',['resource'=>'customers','field'=>'name'])
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>
                                    @include('shared.sortBtn', ['resource' => 'customers', 'field' => 'id'])
                                </th>
                                <th>
                                    @include('shared.sortBtn', ['resource' => 'customers', 'field' => 'name'])
                                </th>
                                <th>
                                    @include('shared.sortBtn', ['resource' => 'customers', 'field' => 'email'])
                                </th>
                                <th>
                                    @include('shared.sortBtn', ['resource' => 'customers', 'field' => 'address'])
                                </th>
                                <th>
                                    @include('shared.sortBtn', ['resource' => 'customers', 'field' => 'created_at'])
                                </th>
                                <th>
                                    Total Paid
                                </th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($customers as $customer)
                                <tr>
                                    <td>{{ $customer->id }}</td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->address }}</td>
                                    <td>{{ $customer->created_at->format('Y-m-d H:i') }}</td>
                                    <td>${{ number_format($customer->totalPaid(), 2) }}</td>
                                    <td>
                                        @include('shared.actionBtns',['resource'=>'customers','data'=>$customer])
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No customers found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
        <div class="p-2">
            {{ $customers->withQueryString()->links() }}
        </div>
    </div>
@endsection
