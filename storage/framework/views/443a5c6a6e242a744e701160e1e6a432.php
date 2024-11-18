

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <h1 class="mb-4 text-center">Editar Tarea</h1>

    <!-- Mostramos los errores de validación -->
    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('tasks.update', $task->id)); ?>" method="POST" class="bg-light p-4 rounded shadow">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" name="title" id="title" class="form-control" value="<?php echo e(old('title', $task->title)); ?>" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea name="description" id="description" class="form-control" rows="3"><?php echo e(old('description', $task->description)); ?></textarea>
        </div>

        <div class="mb-3">
            <label for="area_id" class="form-label">Área</label>
            <select name="area_id" id="area_id" class="form-select" required>
                <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($area->id); ?>" <?php echo e($area->id == $task->area_id ? 'selected' : ''); ?>><?php echo e($area->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="due_date" class="form-label">Fecha de Vencimiento</label>
            <input type="date" name="due_date" id="due_date" class="form-control" value="<?php echo e(old('due_date', \Carbon\Carbon::parse($task->due_date)->format('Y-m-d'))); ?>" required>
        </div>

        <div class="mb-3">
    <label for="status" class="form-label">Estado</label>
    <select name="status" id="status" class="form-select" required>
        <option value="Pendiente" <?php echo e(old('status', $task->status) == 'Pendiente' ? 'selected' : ''); ?>>Pendiente</option>
        <option value="Completada" <?php echo e(old('status', $task->status) == 'Completada' ? 'selected' : ''); ?>>Completada</option>
    </select>
</div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-warning">Actualizar Tarea</button>
            <a href="<?php echo e(auth()->user()->role->name === 'editor' ? route('editor.index') : route('admin.tasks.index')); ?>" class="btn btn-secondary">Cancelar</a>

            <!-- Botón Eliminar solo visible para admin -->
            <?php if(auth()->user()->role->name === 'admin'): ?>
                <form action="<?php echo e(route('tasks.destroy', $task->id)); ?>" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta tarea?');">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">Eliminar Tarea</button>
                </form>
            <?php endif; ?>
        </div>
    </form>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make(auth()->user()->role->name === 'admin' ? 'layouts.admin' : 'layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\ProyectoFinal\sustemia\resources\views/tasks/edit.blade.php ENDPATH**/ ?>