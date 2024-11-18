

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1 class="my-4">Editar Usuario</h1>
    <form action="<?php echo e(route('admin.users.update', $user->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" value="<?php echo e(old('name', $user->name)); ?>" required aria-describedby="nameHelp">
            <div id="nameHelp" class="form-text">Introduce el nombre completo del usuario.</div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="<?php echo e(old('email', $user->email)); ?>" required aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">Introduce un email válido para el usuario.</div>
        </div>

        <div class="mb-3">
            <label for="role_id" class="form-label">Rol</label>
            <select name="role_id" id="role_id" class="form-select" required>
                <option value="" disabled>Selecciona un rol</option>
                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($role->id); ?>" <?php echo e($user->role_id == $role->id ? 'selected' : ''); ?>>
                        <?php echo e($role->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <div class="form-text">Selecciona el rol del usuario.</div>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\ProyectoFinal\sustemia\resources\views/users/edit.blade.php ENDPATH**/ ?>