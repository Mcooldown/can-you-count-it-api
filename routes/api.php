<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\UserItemController;
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

// Auth
Route::post('/add-user', [AuthController::class, 'addUser']);
Route::post('/authenticate-user', [AuthController::class, 'authenticateUser']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('get-auth-user', [AuthController::class, 'getAuthUser']);

// Level
Route::post('/get-all-levels', [LevelController::class, 'getAllLevels']);
Route::post('/get-level-by-id', [LevelController::class, 'getLevelById']);

// Score
Route::post('/add-score', [ScoreController::class, 'addScore']);
Route::post('/get-scores-by-id', [ScoreController::class, 'getScoreById']);
Route::post('/get-scores-by-level-id', [ScoreController::class, 'getScoresByLevelId']);
Route::post('/get-scores-by-user-id', [ScoreController::class, 'getScoresByUserId']);

// Item
Route::post('/get-all-items', [ItemController::class, 'getAllItems']);
Route::post('/get-item-by-id', [ItemController::class, 'getItemById']);

// User Item
Route::post('/get-all-user-items', [UserItemController::class, 'getAllUserItems']);
Route::post('/add-user-item', [UserItemController::class, 'addUserItem']);
Route::post('/use-user-item', [UserItemController::class, 'useUserItem']);
