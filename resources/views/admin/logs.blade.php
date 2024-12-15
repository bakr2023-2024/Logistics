@extends('layouts.layout')

@section('title', 'Logs')

@section('content')
<div class="container mt-4">
    <h2>Activity Logs</h2>
    <div class="col-md-6">
        @include('shared.searchBar',['resource'=>'admins','field'=>'name'])
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead class="table-dark">
                <tr>
                    <th>
                        @include('shared.sortBtn', ['resource' => 'logs', 'field' => 'id'])
                    </th>
                    <th>
                        @include('shared.sortBtn', ['resource' => 'logs', 'field' => 'activity_type'])
                    </th>
                    <th>Description</th>
                    <th>
                        @include('shared.sortBtn', ['resource' => 'logs', 'field' => 'created_at'])
                    </th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $log->activity_type)) }}</td>
                        <td>{{ $log->description }}</td>
                        <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                        <td>
                            @auth('admin')
                            <form action="{{ route('admin.logs.destroy', $log->id) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')"><i class="bi bi-trash"></i></button>
                            </form>
                        @endauth
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No logs available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
<div>
    {{ $logs->withQueryString()->links() }}
</div>
@endsection
