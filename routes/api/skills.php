<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SkillController;

Route::controller(SkillController::class)->group(function () {
    Route::get('/skills', 'index');
    Route::get('/skills/{skill}', 'show');
    Route::post('/skills/{skill}', 'update');
});