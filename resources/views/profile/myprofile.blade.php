@extends('layouts.main')

@section('content')
  <div class="container py-2">
    <h1 class="text-center text-md-start">Perfil de {{ Auth::user()->name }}</h1>

    <div class="card mb-3">
      <div class="card-body">
        <h5 class="card-title">Información del Usuario</h5>
        <p><strong>Nombre:</strong> {{ Auth::user()->name }}</p>
        <p><strong>Apellido:</strong> {{ Auth::user()->surname }}</p>
        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
      </div>
    </div>

    <!-- Contenedor de botones con clases específicas -->
    <div class="d-flex flex-wrap gap-2 justify-content-start">
      <a href="{{ route('profile.edit') }}" class="btn btn-warning" style="width: auto;" aria-label="Editar Perfil">
        <i class="bi bi-pencil"></i> Editar Perfil
      </a>
    </div>
  </div>
@endsection
