@extends('layouts.main') 

@section('title', 'Iniciar Sesión')

@section('content')

<section>
  <div class="container py-5 h-100">
    <div class="row justify-content-center align-items-center h-100">
      <div class="col-md-6 col-lg-5 mb-4 mb-md-0 text-center">
        <img src="{{ url('css/imgs/resource/icono.png') }}" alt="Logo de Sustemia" class="img-fluid mb-4" style="max-width: 150px;">
        <h1 class="fw-normal mb-3" style="color: var(--color-success);">¡Hola de nuevo!</h1>
        <p style="color: var(--color-success);">Te damos la bienvenida a nuestra plataforma.</p>
        <p style="color: var(--color-success);">Ingresá tus datos para continuar.</p>

        <i class="bi bi-helmet-safety icon"></i>
      </div>
      <div class="col-md-6 col-lg-5">
        <div class="card-custom">
          <div class="card-body p-4 p-lg-5 text-dark">
            <form  action="{{ route('auth.login.process') }}" method="post" aria-labelledby="login-form">
              @csrf

              <div class="form-outline mb-4">
                <label class="form-label" for="email"><i class="bi bi-envelope-fill"></i> Correo Electrónico</label>
                <input
                  type="email"
                  id="email"
                  name="email"
                  class="form-control form-control-lg"
                  placeholder="ejemplo@email.com"
                  value="{{ old('email') }}"
                  required
                  aria-required="true"
                >
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-outline mb-4">
                <label class="form-label" for="password"><i class="bi bi-lock-fill"></i> Contraseña</label>
                <input
                  type="password"
                  id="password"
                  name="password"
                  class="form-control form-control-lg"
                  placeholder="xxxx"
                  required
                  aria-required="true"
                >
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>

              <div class="pt-1 mb-4">
                <button class="btn btn-success btn-lg btn-block" type="submit">
                  <i class="bi bi-arrow-right-circle"></i> Iniciar Sesión
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
