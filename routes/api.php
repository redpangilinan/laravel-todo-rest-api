<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Routes for Todo
Route::resource('todos', TodoController::class)->except(['create', 'edit']);
Route::put('/todos/{id}/toggle', [TodoController::class, 'toggleCompleted']);
