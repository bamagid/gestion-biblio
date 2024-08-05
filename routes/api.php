<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LivreController;
use Illuminate\Support\Facades\Route;

Route::post("login", [AuthController::class, "login"]);
Route::apiResource('livres', LivreController::class)->only('index', 'show');
Route::middleware("auth")->group(
    function () {
        Route::get("logout", [AuthController::class, "logout"]);
        // Route::post('livres', [LivreController::class, 'store']);
        Route::apiResource('livres', LivreController::class)->only('store', 'destroy');
        Route::post('livres/{livre}', [LivreController::class, 'update']);
        Route::get("refresh", [AuthController::class, "refresh"]);
    }
);
