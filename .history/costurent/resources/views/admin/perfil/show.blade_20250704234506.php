@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow-md mt-8">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Mi Perfil</h2>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.perfil.update') }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Nombre -->
        <div class="mb-4">
            <label for="nombre" class="block font-medium text-gray-700">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $admin->nombre) }}" required
                class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
        </div>

        <!-- Apellido -->
        <div class="mb-4">
            <label for="apellido" class="block font-medium text-gray-700">Apellido</label>
            <input type="text" name="apellido" id="apellido" value="{{ old('apellido', $admin->apellido) }}" required
                class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
        </div>

        <!-- Correo -->
        <div class="mb-4">
            <label for="correo" class="block font-medium text-gray-700">Correo Electrónico</label>
            <input type="email" name="correo" id="correo" value="{{ old('correo', $admin->correo) }}" required
                class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
        </div>

        <!-- Teléfono -->
        <div class="mb-4">
            <label for="telefono" class="block font-medium text-gray-700">Teléfono</label>
            <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $admin->telefono) }}"
                class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
        </div>

        <!-- Clave nueva -->
        <div class="mb-4">
            <label for="clave" class="block font-medium text-gray-700">Nueva Clave (opcional)</label>
            <input type="password" name="clave" id="clave"
                class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
        </div>

        <!-- Confirmar clave -->
        <div class="mb-6">
            <label for="clave_confirmation" class="block font-medium text-gray-700">Confirmar Clave</label>
            <input type="password" name="clave_confirmation" id="clave_confirmation"
                class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
        </div>

        <button type="submit"
            class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">Actualizar Perfil</button>
    </form>
</div>
@endsection
