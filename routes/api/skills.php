<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SkillController;

Route::controller(SkillController::class)->group(function () {
    Route::get('/skills', 'index');
    Route::get('/skills/{skill}', 'show');
    Route::put('/skills/{skill}', 'update');
    Route::post('/skills', 'store');
    Route::delete('/skills/{skill}', 'destroy');
});