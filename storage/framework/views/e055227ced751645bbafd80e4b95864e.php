

<?php $__env->startSection('content'); ?>
  <div class="container py-2">
    <h1 class="text-center text-md-start">Perfil de <?php echo e(Auth::user()->name); ?></h1>

    <div class="card mb-3">
      <div class="card-body">
        <h5 class="card-title">Información del Usuario</h5>
        <p><strong>Nombre:</strong> <?php echo e(Auth::user()->name); ?></p>
        <p><strong>Apellido:</strong> <?php echo e(Auth::user()->surname); ?></p>
        <p><strong>Email:</strong> <?php echo e(Auth::user()->email); ?></p>
      </div>
    </div>

    <!-- Contenedor de botones con clases específicas -->
    <div class="d-flex flex-wrap gap-2 justify-content-start">
      <a href="<?php echo e(route('profile.edit')); ?>" class="btn btn-warning" style="width: auto;" aria-label="Editar Perfil">
        <i class="bi bi-pencil"></i> Editar Perfil
      </a>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\ProyectoFinal\sustemia\resources\views/profile/myprofile.blade.php ENDPATH**/ ?>