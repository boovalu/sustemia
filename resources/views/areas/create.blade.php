@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="my-4">Crear Nueva Área</h1>
    <form action="{{ route('admin.areas.store') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label for="name" class="form-label">Nombre del Área</label>
            <input type="text" name="name" id="name" class="form-control" required aria-describedby="nameHelp">
            <div id="nameHelp" class="form-text">Introduce el nombre de la nueva área.</div>
        </div>

        <button type="submit" class="btn btn-primary">Crear Área</button>
        <a href="{{ route('admin.areas.index') }}" class="btn btn-secondary">Cancelar</a>

    </form>
</div>
@endsection
