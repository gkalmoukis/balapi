<?php

use App\Http\Controllers\TeamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\TeamPlayerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResource('teams', TeamController::class);
Route::put('teams/{teamId}/players', [TeamPlayerController::class, 'store']);
Route::delete('teams/{teamId}/players/{playerId}', [TeamPlayerController::class, 'destroy']);
Route::apiResource('players', PlayerController::class);
