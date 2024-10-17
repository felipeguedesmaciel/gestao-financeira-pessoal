<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManagementController;

Route::get('/', [ManagementController::class, 'index']);

Route::get('/painel', [ManagementController::class, 'panel']);
