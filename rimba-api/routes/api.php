<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\UserValidationInput;
use App\Http\Middleware\UserValidationUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/users', [UserController::class, "addUser"])->middleware(UserValidationInput::class);
Route::put('/users/{id}', [UserController::class, "editUser"])->middleware(UserValidationUpdate::class);
Route::delete('/users/{id}', [UserController::class, "deleteUser"]);
Route::get('/users/{id}', [UserController::class, "detailUser"]);
Route::get('/users', [UserController::class, "getUsers"]);
