<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ClienteController as AdminClienteController;
use App\Http\Controllers\Admin\DisfrazController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\AlquilerController;
use App\Http\Controllers\ClienteController;

Route::get('/', function () {
    return view('inicio');
})->name('inicio');

// AUTENTICACIÓN
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// RUTAS PROTEGIDAS
Route::middleware('auth')->group(function () {

    // RUTAS PARA ADMINISTRADOR
    Route::middleware('can:admin')->prefix('admin')->name('admin.')->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Perfil
        Route::get('/perfil', [AdminController::class, 'perfil'])->name('perfil');
        Route::put('/perfil', [AdminController::class, 'actualizarPerfil'])->name('perfil.update');

        // Clientes
        Route::get('/clientes', [AdminClienteController::class, 'index'])->name('clientes.index');
        Route::get('/clientes/crear', [AdminClienteController::class, 'create'])->name('clientes.create');
        Route::post('/clientes', [AdminClienteController::class, 'store'])->name('clientes.store');
        Route::get('/clientes/{id}/editar', [AdminClienteController::class, 'edit'])->name('clientes.edit');
        Route::put('/clientes/{id}', [AdminClienteController::class, 'update'])->name('clientes.update');
        Route::delete('/clientes/{id}', [AdminClienteController::class, 'destroy'])->name('clientes.destroy');

        // Disfraces
        Route::resource('/disfraces', DisfrazController::class)->except(['show']);

        // Categorías
        Route::post('/categorias', [CategoriaController::class, 'store'])->name('categorias.store');

        // Alquileres
        Route::get('/alquileres', [AlquilerController::class, 'index'])->name('alquileres.index');
        Route::get('/alquileres/crear', [AlquilerController::class, 'create'])->name('alquileres.create');
        Route::post('/alquileres', [AlquilerController::class, 'store'])->name('alquileres.store');
        Route::post('/alquileres/{id}/cambiar-estado', [AlquilerController::class, 'cambiarEstado'])->name('alquileres.cambiarEstado');
        Route::put('/alquileres/{id}', [AlquilerController::class, 'update'])->name('alquileres.update');
        Route::delete('/alquileres/{id}', [AlquilerController::class, 'destroy'])->name('alquileres.destroy');
    });

    // RUTAS PARA CLIENTE
    Route::middleware('can:cliente')->prefix('cliente')->name('cliente.')->group(function () {
        Route::get('/dashboard', [ClienteController::class, 'dashboard'])->name('dashboard');
        Route::get('/catalogo', [ClienteController::class, 'catalogo'])->name('catalogo');
        Route::get('alquiler/{disfraz}/crear', [ClienteController::class, 'formAlquiler'])->name('alquiler.form');
        Route::post('alquiler/guardar', [ClienteController::class, 'guardarAlquiler'])->name('alquiler.guardar');
        Route::get('/alquileres', [ClienteController::class, 'misAlquileres'])->name('alquileres.index');
        Route::put('/perfil', [ClienteController::class, 'actualizarPerfil'])->name('perfil.update');
    });

    // Cerrar sesión
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
