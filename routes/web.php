<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManagementController;

Route::get('/', [ManagementController::class, 'index']);

Route::get('/painel', [ManagementController::class, 'panel']);

Route::get('/menu-test', function () {
    return view('menu-test');
});
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
