@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Lista de Tareas</h1>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nueva Tarea
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <thead class="table-light">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Título</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Área</th>
                    <th scope="col">Fecha de Vencimiento</th>
                    <th scope="col" @if($tasks->whereNull('completed_at')->count() > 0) style="display:none;" @endif>Fecha de Cierre</th>
                    <th scope="col">Estado</th>
                    <th scope="col" class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->title }}</td>
                        <td>{{ Str::limit($task->description, 50) }}</td>
                        <td>{{ $task->area->name }}</td>
                        <td>{{ $task->due_date->format('d/m/Y') }}</td>
                        <td @if(is_null($task->completed_at)) style="display:none;" @endif>
    @if($task->completed_at)
        {{ $task->completed_at->format('d/m/Y') }}
    @else
        N/A
    @endif
</td>

                        <td>{{ $task->status }}</td>
                        <td class="text-center">
                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm" aria-label="Editar tarea">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="{{ route('tasks.confirmDelete', $task->id) }}" class="btn btn-danger btn-sm" aria-label="Eliminar tarea">
                                <i class="bi bi-trash"></i>
                            </a>
                            <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-info btn-sm" aria-label="Detalles de tarea">
                                <i class="bi bi-info-circle"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
