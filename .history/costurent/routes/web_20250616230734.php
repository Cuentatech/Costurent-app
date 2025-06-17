<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DisfrazController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;

// AUTENTICACIÓN
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// RUTAS PROTEGIDAS POR AUTENTICACIÓN
Route::middleware('auth')->group(function () {

    // RUTAS PARA ADMINISTRACIÓN (solo usuarios con rol admin)
    Route::middleware('can:admin')->prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Clientes
        Route::get('clientes', [AdminController::class, 'index'])->name('clientes.index');
        Route::get('clientes/crear', [AdminController::class, 'createCliente'])->name('clientes.create');
        Route::post('clientes', [AdminController::class, 'guardarCliente'])->name('clientes.guardarCliente');
        Route::get('clientes/{id}/editar', [AdminController::class, 'edit'])->name('clientes.edit');
        Route::put('clientes/{id}', [AdminController::class, 'update'])->name('clientes.update');
        Route::delete('clientes/{id}', [AdminController::class, 'destroy'])->name('clientes.destroy');

        // Disfraces y Categorías
        Route::resource('disfraces', DisfrazController::class)->except(['show']);
        Route::post('/categorias', [CategoriaController::class, 'store'])->name('categorias.store');

        // Alquileres
        Route::get('/alquileres', [AdminController::class, 'listarAlquileres'])->name('alquileres.index');
        Route::post('/alquileres/{id}/cambiar-estado', [AdminController::class, 'cambiarEstadoAlquiler'])->name('alquileres.cambiarEstado');
        Route::delete('/alquileres/{id}', [AdminController::class, 'eliminarAlquiler'])->name('alquileres.destroy');
        Route::put('/admin/alquileres/{id}', [AdminController::class, 'updatealquiler'])->name('alquileres.update');
    });

    // RUTAS PARA CLIENTE (si necesitas añadir funciones futuras)
    Route::middleware('can:cliente')->prefix('cliente')->name('cliente.')->group(function () {
        // Aquí irían rutas para usuarios cliente
    });

    // CERRAR SESIÓN (Logout)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
