@extends('layouts.main')

@section('content')
<div class="container">
    <h1>Editar Perfil de {{ Auth::user()->name }}</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('POST')

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" required>
        </div>

        <div class="mb-3">
            <label for="surname" class="form-label">Apellido</label>
            <input type="text" class="form-control" id="surname" name="surname" value="{{ Auth::user()->surname }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Perfil</button>
        <a href="{{ route('profile.view') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
