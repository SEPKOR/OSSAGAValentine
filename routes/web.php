<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Order Submission API
Route::post('/submit-order', [OrderController::class, 'store']);

// Admin Dashboard (Protected by Basic Auth)
Route::group(['middleware' => 'auth.basic'], function () {
    Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders');
    Route::patch('/admin/orders/{order}/complete', [OrderController::class, 'complete'])->name('admin.orders.complete');
    Route::delete('/admin/orders/{order}', [OrderController::class, 'destroy'])->name('admin.orders.destroy');
});
