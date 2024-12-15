@php
    $routePrefix = auth()->guard('admin')->check() ? 'admin.' : '';
@endphp
<form method="GET" action="{{ route($routePrefix . $resource . '.index') }}" class="form-inline">
    <div class="input-group">
        <input type="hidden" name="searchKey" value="{{ $field }}"/>
        <input type="text" name="searchValue" class="form-control" placeholder="Search by {{ $field }}" value="{{ request()->query('searchValue') }}">
        <button type="submit" class="btn btn-secondary"><i class="bi bi-search"></i></button>
    </div>
</form>
