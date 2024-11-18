  

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
  <h1 class="text-center mb-4">Detalles de la Tarea</h1>

  <div class="card card-custom">
    <div class="card-header text-center">
      <h5 class="card-title text-white"><?php echo e($task->title); ?></h5>
    </div>
    <div class="card-body">
      <!-- Descripción de la tarea -->
      <div class="mb-3">
        <strong>Descripción:</strong>
        <p><?php echo e($task->description); ?></p>
      </div>

      <!-- Área de la tarea -->
      <div class="mb-3">
        <strong>Área:</strong>
        <p class="text-muted"><?php echo e($task->area->name ?? 'N/A'); ?></p>
      </div>

      <!-- Fecha de vencimiento -->
      <div class="mb-3">
        <strong>Fecha de Vencimiento:</strong>
        <p class="text-muted"><?php echo e(\Carbon\Carbon::parse($task->due_date)->format('d/m/Y')); ?></p>
      </div>

      <!-- Estado de la tarea -->
      <div class="mb-3">
        <strong>Estado:</strong>
        <p>
          <span class="badge 
            <?php echo e($task->status === 'Completada' ? 'bg-success' : 
               ($task->status === 'Pendiente' ? 'bg-warning text-dark' : 'bg-danger')); ?>">
            <?php echo e($task->status); ?>

          </span>
        </p>
      </div>
    </div>

    <div class="card-footer d-flex justify-content-between">
      <div>
        <!-- Mostrar el botón de Editar solo para Admin y Editor -->
        <?php if(Auth::user()->role->name === 'admin' || Auth::user()->role->name === 'editor'): ?>
          <a href="<?php echo e(route('tasks.edit', $task->id)); ?>" class="btn btn-warning me-2">Editar Tarea</a>
        <?php endif; ?>

        <!-- Mostrar el botón de Eliminar solo para Admin -->
        <?php if(Auth::user()->role->name === 'admin'): ?>
          <form action="<?php echo e(route('tasks.destroy', $task->id)); ?>" method="POST" class="d-inline">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit" class="btn btn-danger" 
                    onclick="return confirm('¿Estás seguro de que deseas eliminar esta tarea?')">Eliminar Tarea</button>
          </form>
        <?php endif; ?>
      </div>

      <!-- Botón para volver a la lista de tareas o al dashboard -->
      <a href="<?php echo e(auth()->user()->role->name === 'admin' ? route('admin.tasks.index') : route('dashboard.index')); ?>" 
         class="btn btn-secondary">Volver</a>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(auth()->user()->role->name === 'admin' ? 'layouts.admin' : 'layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\ProyectoFinal\sustemia\resources\views/tasks/show.blade.php ENDPATH**/ ?>