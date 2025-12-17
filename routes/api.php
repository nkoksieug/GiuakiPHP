<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiTaskController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
use App\Http\Controllers\ResourceTaskController;

Route::get('tasks/create', [ResourceTaskController::class, 'create']);
Route::apiResource('tasks', ApiTaskController::class)->names('api.tasks');