<?php

use App\Http\Controllers\Api\FootballController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/leagues', [FootballController::class, 'leagues']);
Route::get('/teams', [FootballController::class, 'teams']);
Route::get('/results', [FootballController::class, 'results']);
