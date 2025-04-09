<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PedidoDigistoreController;

// Rota principal (redireciona para /admin/login)
Route::get('/', function () {
    return redirect('/produtores/login');
});