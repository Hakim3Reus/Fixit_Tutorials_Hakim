<?php

use App\Http\Controllers\TutorialController;

Route::get('/tutorials', [TutorialController::class, 'index']);
Route::get('/tutorials/{id}', [TutorialController::class, 'show']);


