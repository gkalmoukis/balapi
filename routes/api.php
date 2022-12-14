<?php

use App\Http\Controllers\ChampionshipController;
use App\Http\Controllers\TeamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\TeamPlayerController;
use App\Models\Championship;

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
Route::apiResource('games', GameController::class);
Route::group([
    'prefix' => 'championships'
], function ()
{
    Route::get('/{id}/close', [ChampionshipController::class, 'updateStatus']);
});
Route::apiResource('championships', ChampionshipController::class);
Route::group([
    'prefix' => 'results'
], function ()
{
    Route::get('/', [ResultController::class, 'index']);
});