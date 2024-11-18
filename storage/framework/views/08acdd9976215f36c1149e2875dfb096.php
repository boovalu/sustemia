

<?php $__env->startSection('content'); ?>
  <div class="container-fluid mt-4">
    <h1 class="mb-4 text-center">Panel de Control de Seguridad e Higiene</h1>
    <p class="text-center m-2">Bienvenido a tu espacio de gestión.</p>
    <p class="text-center"> Aquí podrás crear, editar y supervisar las tareas relacionadas con la seguridad y la higiene laboral de manera eficiente y sencilla.</p>

    <button type="button" class="btn btn-success mb-4" data-bs-toggle="modal" data-bs-target="#createTaskModal" aria-label="Crear Nueva Tarea">
      <i class="bi bi-plus-circle"></i> Crear Nueva Tarea
    </button>

    <!-- Modal para Crear Nueva Tarea -->
    <div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="createTaskModalLabel">Crear Nueva Tarea</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <form id="createTaskForm" method="POST" action="<?php echo e(route('tasks.store')); ?>">
              <?php echo csrf_field(); ?>
              <div class="mb-3">
                <label for="title" class="form-label">Título</label>
                <input type="text" class="form-control" id="title" name="title" required aria-describedby="titleHelp">
                <div id="titleHelp" class="form-text">Introduce un título descriptivo para la tarea.</div>
              </div>
              <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
              </div>
              <div class="mb-3">
                <label for="due_date" class="form-label">Fecha de Vencimiento</label>
                <input type="date" class="form-control" id="due_date" name="due_date" required>
              </div>
              <div class="mb-3">
                <label for="area" class="form-label">Área</label>
                <select id="area" name="area_id" class="form-select" required>
                  <option value="">Seleccionar Área</option>
                  <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($area->id); ?>"><?php echo e($area->name); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>
              <button type="submit" class="btn btn-success">Crear Tarea</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="mb-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Filtrar Tareas</h5>
          <form method="GET" action="<?php echo e(route('editor.index')); ?>" aria-label="Filtrar tareas">
            <div class="row g-3 mb-3">
              <div class="col-md-12">
                <label for="search" class="form-label">Buscar Tareas</label>
                <input type="text" class="form-control" id="search" name="search" value="<?php echo e(request('search')); ?>" placeholder="Buscar por título o descripción" oninput="this.form.submit()">
              </div>
              <div class="col-md-2">
                <label for="filterArea" class="form-label">Área</label>
                <select id="filterArea" name="area" class="form-select" onchange="this.form.submit()">
                  <option value="">Seleccionar Área</option>
                  <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($area->id); ?>" <?php echo e(request('area') == $area->id ? 'selected' : ''); ?>><?php echo e($area->name); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>
              <div class="col-md-2">
                <label for="month" class="form-label">Mes</label>
                <select id="month" name="month" class="form-select" onchange="this.form.submit()">
                  <option value="">Seleccionar Mes</option>
                  <?php for($i = 1; $i <= 12; $i++): ?>
                    <option value="<?php echo e($i); ?>" <?php echo e(request('month') == $i ? 'selected' : ''); ?>>
                      <?php echo e(Carbon\Carbon::create()->month($i)->translatedFormat('F')); ?>

                    </option>
                  <?php endfor; ?>
                </select>
              </div>
              <div class="col-md-2">
                <label for="year" class="form-label">Año</label>
                <select id="year" name="year" class="form-select" onchange="this.form.submit()">
                  <option value="">Seleccionar Año</option>
                  <?php for($year = now()->year; $year >= 2000; $year--): ?>
                    <option value="<?php echo e($year); ?>" <?php echo e(request('year') == $year ? 'selected' : ''); ?>><?php echo e($year); ?></option>
                  <?php endfor; ?>
                </select>
              </div>
              <div class="col-md-2">
                <label for="filterStatus" class="form-label">Estado</label>
                <select id="filterStatus" name="status" class="form-select" onchange="this.form.submit()">
                  <option value="">Seleccionar Estado</option>
                  <option value="Pendiente" <?php echo e(request('status') == 'Pendiente' ? 'selected' : ''); ?>>Pendiente</option>
                  <option value="Completada" <?php echo e(request('status') == 'Completada' ? 'selected' : ''); ?>>Completada</option>
                  <!--option value="Vencida" <?php echo e(request('status') == 'Vencida' ? 'selected' : ''); ?>>Vencida</option-->
                </select>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="mb-3">
      <div class="alert alert-info d-flex align-items-center">
        <div class="me-3">
          <strong>Nota:</strong>
        </div>
        <div class="d-flex flex-wrap">
          <div class="me-3">
            <span class="badge bg-danger">&nbsp;&nbsp;&nbsp;&nbsp;</span> Tarea Vencida
          </div>
          <div class="me-3">
            <span class="badge bg-warning text-dark">&nbsp;&nbsp;&nbsp;&nbsp;</span> Tarea Pendiente
          </div>
          <div class="me-3">
            <span class="badge bg-success">&nbsp;&nbsp;&nbsp;&nbsp;</span> Tarea Completada
          </div>
        </div>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Fecha de Creación</th>
            <th>Título</th>
            <th>Descripción</th>
            <th>Área</th>
            <th>Fecha de Vencimiento</th>
            <th scope="col">Fecha de Cierre</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="<?php echo e($task->due_date < now() ? 'table-danger' : ($task->status == 'Completada' ? 'table-success' : 'table-warning')); ?>">
              <td><?php echo e($task->created_at ? $task->created_at->format('d/m/Y') : 'Sin fecha'); ?></td>
              <td><?php echo e($task->title); ?></td>
              <td><?php echo e($task->description); ?></td>
              <td><?php echo e($task->area->name ?? 'Sin área'); ?></td>
              <td><?php echo e($task->due_date ? $task->due_date->format('d/m/Y') : 'Sin fecha'); ?></td>
              <td><?php echo e($task->completed_at ? $task->completed_at->format('d/m/Y') : ''); ?></td>
              <td>
                <span class="badge <?php echo e($task->status == 'Completada' ? 'bg-success' : ($task->status == 'Pendiente' ? 'bg-warning text-dark' : 'bg-danger text-white')); ?>">
                  <?php echo e($task->status); ?>

                </span>
              </td>
              <td class="d-flex">
                <a href="<?php echo e(route('tasks.edit', $task->id)); ?>" class="btn btn-warning me-1" aria-label="Editar Tarea">
                  <i class="bi bi-pencil"></i> Editar
                </a>
                <!--a href="#" class="btn btn-danger me-1" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal<?php echo e($task->id); ?>" aria-label="Eliminar Tarea">
                  <i class="bi bi-trash"></i> Eliminar
                </a-->
                <a href="<?php echo e(route('tasks.show', $task->id)); ?>" class="btn btn-info" aria-label="Ver Detalles">
                  <i class="bi bi-eye"></i> Detalles
                </a>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
      </table>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\ProyectoFinal\sustemia\resources\views/dashboards/editor.blade.php ENDPATH**/ ?>