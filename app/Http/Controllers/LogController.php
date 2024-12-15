<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Traits\SearchAndSort;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class LogController extends Controller
{
    use SearchAndSort;
    public function index(Request $request)
    {
        Gate::authorize('admin');
        $logs = $this->applySearchAndSort(Log::query(), $request)->paginate(10);
        return view('admin.logs', compact('logs'));
    }
    public function destroy(Request $request, Log $log)
    {
        Gate::authorize('admin');
        $log->delete();
        return redirect()->route('admin.logs.index')->with('success', 'Log deleted successfully');
    }
}
