<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DisfrazController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;

// LOGIN
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

//REGISTER
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// AUTENTIFICACIÓN POR ROL
Route::middleware('auth')->group(function () {

// RUTAS PARA ADMINISTRACIÓN
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
    // Disfraces
    Route::resource('disfraces', DisfrazController::class)->except(['show']);
    Route::post('/categorias', [CategoriaController::class, 'store'])->name('categorias.store');

    // Alquileres
    Route::get('/alquileres', [AdminController::class, 'listarAlquileres'])->name('alquileres.index');
    Route::post('/alquileres/{id}/cambiar-estado', [AdminController::class, 'cambiarEstadoAlquiler'])->name('alquileres.cambiarEstado');
    Route::delete('/alquileres/{id}', [AdminController::class, 'eliminarAlquiler'])->name('alquileres.destroy');
    Route::put('/admin/alquileres/{id}', [AdminController::class, 'updatealquiler'])->name('alquileres.update');
});

// RUTAS PARA CLIENTE
    Route::middleware('can:cliente')->prefix('cliente')->name('cliente.')->group(function () {
    });


    //LOGOUT
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});
