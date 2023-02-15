<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

Route::controller(EmployeeController::class)->group(function () {
    Route::get('/employees', 'index');
    Route::get('/employees/{employee}', 'show');
    Route::put('/employees/{employee}', 'update');
    Route::post('/employees', 'store');
    Route::delete('/employees/{employee}', 'destroy');
    Route::post('/employees/{employee}/skills', 'attachSkills');
    Route::delete('/employees/{employee}/skills', 'removeSkills');
});