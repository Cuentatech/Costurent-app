<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function dashboard()
    {
        return 'Dashboard Cliente';
    }

    public function listarDisfraces()
    {
        return 'Lista de Disfraces (Cliente)';
    }

    public function mostrarDisfraz($id)
    {
        return "Mostrar Disfraz $id (Cliente)";
    }

    public function reservar($id)
    {
        return "Reservar Disfraz $id (Cliente)";
    }

    public function historialAlquileres()
    {
        return 'Historial de Alquileres (Cliente)';
    }

    public function cancelarReserva($id)
    {
        return "Cancelar Reserva $id (Cliente)";
    }
}
