<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait SearchAndSort
{
    public function applySearchAndSort($query, Request $request, $defaultSortKey = 'id', $defaultSortValue = 'asc')
    {
        $searchKey = strtolower($request->get('searchKey', ''));
        $searchValue = $request->get('searchValue', '');
        $sortKey = $request->get('sortKey', $defaultSortKey);
        $sortValue = $request->get('sortValue', $defaultSortValue);

        return $query->when($searchValue, fn($q) => $q->where($searchKey, 'like', '%' . $searchValue . '%'))->orderBy($sortKey, $sortValue);
    }
}
