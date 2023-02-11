<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/companies/{company}/users', [UserController::class, 'show']);
Route::post('/companies/{company}/users', [UserController::class, 'store']);
Route::post('/companies/{company}/users/{user}', [UserController::class, 'update']);
Route::delete('/companies/{company}/users/{user}', [UserController::class, 'destroy']);