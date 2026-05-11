<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PesajeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PrediccionController;
use App\Http\Controllers\ReporteController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // =========================
    // DASHBOARD
    // =========================
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // =========================
    // PESAJES
    // =========================
    Route::get('/pesajes', [PesajeController::class, 'index'])
        ->name('pesajes.index');

    Route::get('/pesajes/create', [PesajeController::class, 'create'])
        ->name('pesajes.create');

    Route::post('/pesajes', [PesajeController::class, 'store'])
        ->name('pesajes.store');

    // =========================
    // PREDICCIÓN IA
    // =========================
    Route::get('/prediccion', [PrediccionController::class, 'index'])
        ->name('prediccion');

    // =========================
    // REPORTES
    // =========================

    // ✅ CORRECTO: usar controlador
    Route::get('/reportes', [ReporteController::class, 'index'])
        ->name('reportes.index');

    // PDF
    Route::get('/reportes/pdf', [ReporteController::class, 'pdf'])
        ->name('reportes.pdf');

});