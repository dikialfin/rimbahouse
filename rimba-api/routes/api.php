<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\UserValidationInput;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/users', [UserController::class, "addUser"])->middleware(UserValidationInput::class);
