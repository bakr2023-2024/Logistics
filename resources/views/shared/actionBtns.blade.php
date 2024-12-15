@php
    $routePrefix = auth()->guard('admin')->check() ? 'admin.' : '';
@endphp

<div class="action-buttons">
    @can('view', $data)
        <a href="{{ route($routePrefix . $resource . '.show', $data->id) }}" class="btn btn-sm btn-info">
            <i class="bi bi-eye"></i>
        </a>
    @endcan

    @can('update', $data)
        <a href="{{ route($routePrefix . $resource . '.edit', $data->id) }}" class="btn btn-sm btn-warning">
            <i class="bi bi-pencil"></i>
        </a>
    @endcan

    @can('delete', $data)
        <form method="POST" action="{{ route($routePrefix . $resource . '.destroy', $data->id) }}" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">
                <i class="bi bi-trash"></i>
            </button>
        </form>
    @endcan
</div>
