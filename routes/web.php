<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManagementController;

Route::get('/', [ManagementController::class, 'index']);

Route::get('/menu-test', function () {
    return view('menu-test');
});
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [ManagementController::class, 'panel'] )->name('dashboard');
});
