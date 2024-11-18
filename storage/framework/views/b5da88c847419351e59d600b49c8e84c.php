

<?php $__env->startSection('content'); ?>
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
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($user->name); ?></td>
                    <td><?php echo e($user->email); ?></td>
                    <td><?php echo e($user->role ? $user->role->name : 'Sin rol'); ?></td>
                    <td class="text-center">
                        <a href="<?php echo e(route('users.edit', $user->id)); ?>" class="btn btn-warning btn-sm" aria-label="Editar usuario <?php echo e($user->name); ?>">Editar</a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($area->name); ?></td>
                    <td><?php echo e($area->tasks->count()); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($task->title); ?></td>
                    <td><?php echo e($task->description); ?></td>
                    <td><?php echo e($task->area ? $task->area->name : 'Sin área'); ?></td>
                    <td><?php echo e($task->due_date ? $task->due_date->format('d/m/Y') : 'Sin fecha'); ?></td>
                    <td>
                        <span class="badge <?php echo e($task->status == 'Completada' ? 'bg-success' : ($task->status == 'Pendiente' ? 'bg-warning' : 'bg-danger')); ?>">
                            <?php echo e($task->status); ?>

                        </span>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\ProyectoFinal\sustemia\resources\views/dashboards/admin.blade.php ENDPATH**/ ?>