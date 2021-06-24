<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoxController;
use App\Http\Controllers\CardController;

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

Route::middleware('api')->group(function () {
    Route::get('columns', [BoxController::class, 'getAll']);
    Route::get('columns/{id}', [BoxController::class, 'get']);
    Route::post('columns', [BoxController::class, 'create']);
    Route::patch('columns/{id}', [BoxController::class, 'updateTitle']);
    Route::patch('columns/{id}/move', [BoxController::class, 'move']);
    Route::delete('columns/{id}', [BoxController::class, 'delete']);

    Route::get('cards/{id}', [CardController::class, 'get']);
    Route::post('cards', [CardController::class, 'create']);
    Route::patch('cards/{id}', [CardController::class, 'updateContents']);
    Route::patch('cards/{id}/deadline', [CardController::class, 'updateDeadline']);
    Route::patch('cards/{id}/move', [CardController::class, 'move']);
    Route::patch('cards/{id}/archive', [CardController::class, 'archive']);
    Route::delete('cards/{id}', [CardController::class, 'delete']);
});