@extends('layouts.layout')

@section('content')
    <div class="container">
        <h1 class="my-4">Admins Management</h1>
        <div class="row mb-3">
            <div class="col-md-6">
                @include('shared.searchBar',['resource'=>'admins','field'=>'name'])
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>
                                    @include('shared.sortBtn', ['resource' => 'admins', 'field' => 'id'])
                                </th>
                                <th>
                                    @include('shared.sortBtn', ['resource' => 'admins', 'field' => 'name'])
                                </th>
                                <th>
                                    @include('shared.sortBtn', ['resource' => 'admins', 'field' => 'email'])
                                </th>
                                <th>
                                    @include('shared.sortBtn', ['resource' => 'admins', 'field' => 'created_at'])
                                </th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($admins as $admin)
                                <tr>
                                    <td>{{ $admin->id }}</td>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>{{ $admin->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        @include('shared.actionBtns',['resource'=>'admins','data'=>$admin])
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No admins found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <div class="p-2">
            {{ $admins->withQueryString()->links() }}
        </div>
    </div>
@endsection
