<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PedidoCartPandaController;

// 
Route::get('/user', function (Request $request) {
    return $request->user();
});

// ZivkoOrderdigistore
Route::post('/orderdigistore', [OrderController::class, 'store']);

