<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('auth:web')->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::resource('shipments', ShipmentController::class)->only(['create', 'store', 'show', 'index']);
    Route::resource('tickets', TicketController::class)->except(['edit', 'update', 'delete']);
    Route::resource('customers', CustomerController::class)->except(['create', 'store', 'index']);
});
Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
    Route::resource('admins', AdminController::class)->except(['create', 'store']);
    Route::resource('customers', CustomerController::class)->except(['create', 'store']);
    Route::resource('shipments', ShipmentController::class)->except(['create', 'store']);
    Route::resource('tickets', TicketController::class)->except(['create', 'store']);
    Route::resource('logs', LogController::class)->only(['index', 'destroy']);
    Route::get('/report', ReportController::class)->name('report.index');
});
