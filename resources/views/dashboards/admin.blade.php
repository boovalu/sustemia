@extends('layouts.main')

@section('content')
<div class="container-fluid mt-4">
    <h1 class="mb-4 text-center text-primary">Panel de Administración</h1>

    <!-- Tabla de Usuarios -->
    <h2 class="mb-4 text-success">Usuarios</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-primary">
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Correo Electrónico</th>
                    <th scope="col">Rol</th>
                    <th scope="col" class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role ? $user->role->name : 'Sin rol' }}</td>
                    <td class="text-center">
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm" aria-label="Editar usuario {{ $user->name }}">Editar</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Tabla de Áreas -->
    <h2 class="mb-4 text-success">Áreas</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-primary">
                <tr>
                    <th scope="col">Nombre del Área</th>
                    <th scope="col">Número de Tareas</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($areas as $area)
                <tr>
                    <td>{{ $area->name }}</td>
                    <td>{{ $area->tasks->count() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Tabla de Tareas -->
    <h2 class="mb-4 text-success">Tareas</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-primary">
                <tr>
                    <th scope="col">Título</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Área</th>
                    <th scope="col">Fecha de Vencimiento</th>
                    <th scope="col">Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->description }}</td>
                    <td>{{ $task->area ? $task->area->name : 'Sin área' }}</td>
                    <td>{{ $task->due_date ? $task->due_date->format('d/m/Y') : 'Sin fecha' }}</td>
                    <td>
                        <span class="badge {{ $task->status == 'Completada' ? 'bg-success' : ($task->status == 'Pendiente' ? 'bg-warning' : 'bg-danger') }}">
                            {{ $task->status }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
