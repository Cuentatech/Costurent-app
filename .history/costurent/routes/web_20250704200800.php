<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\DisfrazController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\AlquilerController;

// AUTENTICACIÓN
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// RUTAS PROTEGIDAS POR AUTENTICACIÓN
Route::middleware('auth')->group(function () {

    // RUTAS PARA ADMINISTRADOR
    Route::middleware('can:admin')->prefix('admin')->name('admin.')->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Perfil del administrador
        Route::get('/perfil', [AdminController::class, 'perfil'])->name('perfil');
        Route::put('/perfil', [AdminController::class, 'actualizarPerfil'])->name('perfil.update');

        // Clientes
        Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
        Route::get('/clientes/crear', [ClienteController::class, 'create'])->name('clientes.create');
        Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');
        Route::get('/clientes/{id}/editar', [ClienteController::class, 'edit'])->name('clientes.edit');
        Route::put('/clientes/{id}', [ClienteController::class, 'update'])->name('clientes.update');
        Route::delete('/clientes/{id}', [ClienteController::class, 'destroy'])->name('clientes.destroy');

        // Disfraces
        Route::resource('/disfraces', DisfrazController::class)->except(['show']);

        // Categorías
        Route::post('/categorias', [CategoriaController::class, 'store'])->name('categorias.store');

        // Alquileres
        Route::get('/alquileres', [AlquilerController::class, 'index'])->name('alquileres.index');
        Route::post('/alquileres/{id}/cambiar-estado', [AlquilerController::class, 'cambiarEstado'])->name('alquileres.cambiarEstado');
        Route::delete('/alquileres/{id}', [AlquilerController::class, 'destroy'])->name('alquileres.destroy');
        Route::put('/alquileres/{id}', [AlquilerController::class, 'update'])->name('alquileres.update');
    });

    // RUTAS PARA CLIENTE (si necesitas añadir)
    Route::middleware('can:cliente')->prefix('cliente')->name('cliente.')->group(function () {
        // ...
    });

    // CERRAR SESIÓN
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
