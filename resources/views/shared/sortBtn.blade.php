@php
    $routePrefix = auth()->guard('admin')->check() ? 'admin.' : '';
    $currentOrder = request()->query('sortValue') ?? 'asc';
    $newOrder = $currentOrder === 'asc' ? 'desc' : 'asc';
@endphp

<form method="GET" action="{{ route($routePrefix . $resource . '.index') }}" class="form-inline d-inline">
    <input type="hidden" name="sortValue" value="{{ $newOrder }}">
    <input type="hidden" name="sortKey" value="{{ $field }}">

    <button type="submit" class="btn btn-primary d-flex">
        {{ ucfirst($field) }}
        <i class="bi {{ $newOrder === 'asc' ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
    </button>
</form>
