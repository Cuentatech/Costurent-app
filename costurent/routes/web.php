<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
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
    Route::get('/clientes', [AdminController::class, 'index'])->name('clientes.index');       // Listar + búsqueda
    Route::post('/clientes', [AdminController::class, 'guardarCliente'])->name('clientes.store'); // Guardar nuevo cliente

    // Disfraces
    Route::get('/disfraces', [AdminController::class, 'listarDisfraces'])->name('disfraces.index');
    Route::get('/disfraces/crear', [AdminController::class, 'crearDisfraz'])->name('disfraces.crear');
    Route::post('/disfraces', [AdminController::class, 'guardarDisfraz'])->name('disfraces.guardar');
    Route::get('/disfraces/{id}/editar', [AdminController::class, 'editarDisfraz'])->name('disfraces.editar');
    Route::put('/disfraces/{id}', [AdminController::class, 'actualizarDisfraz'])->name('disfraces.actualizar');
    Route::delete('/disfraces/{id}', [AdminController::class, 'eliminarDisfraz'])->name('disfraces.eliminar');

    // Alquileres
    Route::get('/alquileres', [AdminController::class, 'listarAlquileres'])->name('alquileres.index');
    Route::post('/alquileres/{id}/cambiar-estado', [AdminController::class, 'cambiarEstadoAlquiler'])->name('alquileres.cambiarEstado');
    Route::post('/alquileres/{id}/sancionar', [AdminController::class, 'aplicarSancion'])->name('alquileres.sancionar');
});

// RUTAS PARA CLIENTE
    Route::middleware('can:cliente')->prefix('cliente')->name('cliente.')->group(function () {
    Route::get('/dashboard', [ClienteController::class, 'dashboard'])->name('dashboard');
    Route::get('/disfraces', [ClienteController::class, 'listarDisfraces'])->name('disfraces');
    Route::get('/disfraces/{id}', [ClienteController::class, 'mostrarDisfraz'])->name('disfraces.mostrar');
    Route::post('/disfraces/{id}/reservar', [ClienteController::class, 'reservar'])->name('disfraces.reservar');
    Route::get('/alquileres/historial', [ClienteController::class, 'historialAlquileres'])->name('alquileres.historial');
    Route::post('/alquileres/{id}/cancelar', [ClienteController::class, 'cancelarReserva'])->name('alquileres.cancelar');
    });

    // Ruta de logout si la tienes en AuthController
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});
