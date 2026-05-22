<?php

use App\Http\Controllers\ReceitasController;
use Illuminate\Support\Facades\Route;

Route::get('/receitas/buscar', [ReceitasController::class, 'buscarReceita']);
