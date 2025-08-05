<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

Route::get('/', function () {
    return view('index');
});

Route::controller(AuthController::class)->middleware(['isLogged'])->name('auth.')->group(function() {
    Route::get('login', 'index')->name('login.index');
    Route::post('auth', 'authenticate')->name('authenticate');
});

Route::controller(DashboardController::class)->middleware(['can:superadmin-access', 'auth'])->prefix('dashboard')->name('dashboard.')->group(function() {
    Route::get('/', 'index')->name('index');
    Route::get('get-customer-paginate', 'getCustomerPaginate')->name('get-customer-paginate');
    Route::post('action', 'action')->name('action');
    Route::post('get-customer-by-id', 'getCustomerById')->name('get_customer_by_id');
});
