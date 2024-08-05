<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LivreController;
use Illuminate\Support\Facades\Route;

Route::post("login", [AuthController::class, "login"]);
Route::apiResource('livres', LivreController::class)->only('index', 'show', 'store');
Route::middleware("auth")->group(
    function () {
        Route::get("logout", [AuthController::class, "logout"]);
        Route::get("refresh", [AuthController::class, "refresh"]);
    }
);
