<?php

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

Route::post('/login', [\App\Http\Controllers\Api\Auth\LoginController::class, 'login']);

Route::group(['middleware' => 'auth:api'], function () {

    Route::prefix('users')->group(function () {
        Route::patch('/{id}', [\App\Http\Controllers\Api\UserController::class, 'update']);

        Route::prefix('{id}/lists')->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\TodoListController::class, 'index']);
            Route::post('/', [\App\Http\Controllers\Api\TodoListController::class, 'store']);
            Route::get('/{listId}', [\App\Http\Controllers\Api\TodoListController::class, 'show']);
            Route::patch('/{listId}', [\App\Http\Controllers\Api\TodoListController::class, 'update']);
            Route::delete('/{listId}', [\App\Http\Controllers\Api\TodoListController::class, 'delete']);

            Route::prefix('tasks')->group(function () {
                Route::get('/', [\App\Http\Controllers\Api\TaskController::class, 'index']);
                Route::post('/', [\App\Http\Controllers\Api\TaskController::class, 'store']);
                Route::get('/{taskId}', [\App\Http\Controllers\Api\TaskController::class, 'show']);
                Route::patch('/{taskId}', [\App\Http\Controllers\Api\TaskController::class, 'update']);
                Route::delete('/{taskId}', [\App\Http\Controllers\Api\TaskController::class, 'delete']);
            });
        });
    });

});
