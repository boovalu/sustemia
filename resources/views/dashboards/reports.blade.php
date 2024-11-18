@extends(auth()->user()->role->name === 'admin' ? 'layouts.admin' : 'layouts.main')

@section('content')
<div class="container my-4">
  <!-- Título del Dashboard -->
  <h1 class="text-center mb-5 text-dark">Dashboard de Reportes</h1>

  @if(auth()->user()->role->name === 'admin')
  <div class="row text-center my-4">
    <!-- Total de Usuarios -->
    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
      <a href="{{ route('users.index') }}" class="text-decoration-none">
        <div class="card shadow-lg border-primary">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
              <h2 class="card-title text-primary">Total de Usuarios</h2>
              <i class="fas fa-users fa-3x text-primary"></i>
            </div>
            <p class="card-text h1">{{ $totalUsersCount }}</p>
          </div>
        </div>
      </a>
    </div>

    <!-- Total de Áreas -->
    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
      <a href="{{ route('areas.index') }}" class="text-decoration-none">
        <div class="card shadow-lg border-danger">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
              <h2 class="card-title text-danger">Total de Áreas</h2>
              <i class="fas fa-cogs fa-3x text-danger"></i>
            </div>
            <p class="card-text h1">{{ $totalAreasCount }}</p>
          </div>
        </div>
      </a>
    </div>

    <!-- Total de Tareas -->
    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
      <a href="{{ route('tasks.index') }}" class="text-decoration-none">
        <div class="card shadow-lg border-warning">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
              <h2 class="card-title text-warning">Tareas Creadas</h2>
              <i class="fas fa-tasks fa-3x text-warning"></i>
            </div>
            <p class="card-text h1">{{ $totalTasksCount }}</p>
          </div>
        </div>
      </a>
    </div>
  </div>
  @endif

  <!-- Tareas Próximas a Vencer y Retrasadas -->
  <div class="row my-4">
    <!-- Tareas Próximas a Vencer -->
    <div class="col-md-4 mb-4">
      <h2 class="text-primary">Tareas Próximas a Vencer</h2>
      <ul class="list-group">
        @if($upcomingTasks->isEmpty())
        <li class="list-group-item text-center">No hay tareas próximas a vencer.</li>
        @else
        @foreach($upcomingTasks as $task)
        <li class="list-group-item">
          <strong>{{ $task->title }}</strong> - Vence el {{ $task->due_date->format('d/m/Y') }}
        </li>
        @endforeach
        @endif
      </ul>
    </div>

    <!-- Tareas Retrasadas -->
    <div class="col-md-4 mb-4">
      <h2 class="text-danger">Tareas Retrasadas</h2>
      <ul class="list-group">
        @if($overdueTasks->isEmpty())
        <li class="list-group-item text-center">No hay tareas retrasadas.</li>
        @else
        @foreach($overdueTasks as $task)
        <li class="list-group-item list-group-item-danger">
          <strong>{{ $task->title }}</strong> - Debió entregarse el {{ $task->due_date->format('d/m/Y') }}
        </li>
        @endforeach
        @endif
      </ul>
    </div>

    <!-- Tareas Completadas -->
    <div class="col-md-4 mb-4">
      <h2 class="text-success">Tareas Completadas</h2>
      <ul class="list-group">
        @if($completedTasksCount === 0)
        <li class="list-group-item text-center">No hay tareas completadas.</li>
        @else
        <li class="list-group-item text-center">Total de tareas completadas: {{ $completedTasksCount }}</li>
        @endif
      </ul>
    </div>
  </div>

  <!-- Resumen de Tareas por Estado -->
  <div class="row my-4">
    <div class="col-md-12">
      <h3 class="text-center mb-4">Resumen de Tareas</h3>
      <div class="row justify-content-center">
        <!-- Tareas Completadas -->
        <div class="col-md-3 col-sm-6 mb-2">
          <div class="card text-white bg-primary shadow-sm">
            <div class="card-body text-center">
              <h5 class="card-title">Completadas</h5>
              <p class="h2">{{ $completedTasksCount }}</p>
            </div>
          </div>
        </div>

        <!-- Tareas Pendientes -->
        <div class="col-md-3 col-sm-6 mb-2">
          <div class="card text-white bg-warning shadow-sm">
            <div class="card-body text-center">
              <h5 class="card-title">Pendientes</h5>
              <p class="h2">{{ $pendingTasksCount }}</p>
            </div>
          </div>
        </div>

        <!-- Tareas Retrasadas -->
        <div class="col-md-3 col-sm-6 mb-2">
          <div class="card text-white bg-danger shadow-sm">
            <div class="card-body text-center">
              <h5 class="card-title">Retrasadas</h5>
              <p class="h2">{{ $overdueTasksCount }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Gráfico de Estado de Tareas -->
  <div class="row my-4">
    <div class="col-md-12">
      <h2 class="text-primary">Gráfico de Tareas por Estado</h2>
      <div class="chart-container">
        <canvas id="tasksStatusChart" aria-label="Gráfico de Estado de Tareas" role="img"></canvas>
      </div>
      <script>
        const taskStatusData = @json($taskStatusData);
        const labels = Object.keys(taskStatusData);
        const data = Object.values(taskStatusData);

        const ctx = document.getElementById('tasksStatusChart').getContext('2d');

        const tasksStatusChart = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: labels,
            datasets: [{
              label: 'Cantidad de Tareas',
              data: data,
              backgroundColor: [
                'rgba(75, 192, 192, 0.6)',
                'rgba(153, 102, 255, 0.6)',
                'rgba(255, 99, 132, 0.6)'
              ],
              borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 99, 132, 1)'
              ],
              borderWidth: 1
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: { position: 'top' },
              title: { display: true, text: 'Estado de Tareas' }
            },
            scales: {
              y: { beginAtZero: true },
              x: { beginAtZero: true }
            }
          }
        });
      </script>
    </div>
  </div>
</div>
@endsection
