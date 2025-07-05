<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\Admin\DisfrazController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\AlquilerController;
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
    Route::middleware('can:admin')->prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Perfil
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
        Route::get('/alquileres/crear', [AlquilerController::class, 'create'])->name('alquileres.create'); // Agregado
        Route::post('/alquileres', [AlquilerController::class, 'store'])->name('alquileres.store');       // Agregado
        Route::post('/alquileres/{id}/cambiar-estado', [AlquilerController::class, 'cambiarEstado'])->name('alquileres.cambiarEstado');
        Route::put('/alquileres/{id}', [AlquilerController::class, 'update'])->name('alquileres.update');
        Route::delete('/alquileres/{id}', [AlquilerController::class, 'destroy'])->name('alquileres.destroy');
    });

    Route::middleware('can:cliente')->prefix('cliente')->name('cliente.')->group(function () {
        // ...
    });

    // Cerrar sesión
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

