<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return 'Dashboard Admin';
    }

    public function listarClientes()
    {
        return 'Lista de Clientes (Admin)';
    }

    public function listarDisfraces()
    {
        return 'Lista de Disfraces (Admin)';
    }

    public function crearDisfraz()
    {
        return 'Crear Disfraz (Admin)';
    }

    public function guardarDisfraz(Request $request)
    {
        return 'Guardar Disfraz (Admin)';
    }

    public function editarDisfraz($id)
    {
        return "Editar Disfraz $id (Admin)";
    }

    public function actualizarDisfraz(Request $request, $id)
    {
        return "Actualizar Disfraz $id (Admin)";
    }

    public function eliminarDisfraz($id)
    {
        return "Eliminar Disfraz $id (Admin)";
    }

    public function listarAlquileres()
    {
        return 'Lista de Alquileres (Admin)';
    }

    public function cambiarEstadoAlquiler($id)
    {
        return "Cambiar estado de Alquiler $id (Admin)";
    }

    public function aplicarSancion($id)
    {
        return "Aplicar sanción a Alquiler $id (Admin)";
    }
}
