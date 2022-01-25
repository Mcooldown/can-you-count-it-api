<?php

use App\Http\Controllers\LevelController;
use App\Http\Controllers\ScoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/store-score', [ScoreController::class, 'storeScore']);
Route::post('/levels', [LevelController::class, 'getAllLevels']);
Route::post('/levels/{levelId}', [LevelController::class, 'getLevelById']);
