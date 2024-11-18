 

<?php $__env->startSection('title', 'Iniciar Sesión'); ?>

<?php $__env->startSection('content'); ?>

<section>
  <div class="container py-5 h-100">
    <div class="row justify-content-center align-items-center h-100">
      <div class="col-md-6 col-lg-5 mb-4 mb-md-0 text-center">
        <img src="<?php echo e(url('css/imgs/resource/icono.png')); ?>" alt="Logo de Sustemia" class="img-fluid mb-4" style="max-width: 150px;">
        <h1 class="fw-normal mb-3" style="color: var(--color-success);">¡Hola de nuevo!</h1>
        <p style="color: var(--color-success);">Te damos la bienvenida a nuestra plataforma.</p>
        <p style="color: var(--color-success);">Ingresá tus datos para continuar.</p>

        <i class="bi bi-helmet-safety icon"></i>
      </div>
      <div class="col-md-6 col-lg-5">
        <div class="card-custom">
          <div class="card-body p-4 p-lg-5 text-dark">
            <form  action="<?php echo e(route('auth.login.process')); ?>" method="post" aria-labelledby="login-form">
              <?php echo csrf_field(); ?>

              <div class="form-outline mb-4">
                <label class="form-label" for="email"><i class="bi bi-envelope-fill"></i> Correo Electrónico</label>
                <input
                  type="email"
                  id="email"
                  name="email"
                  class="form-control form-control-lg"
                  placeholder="ejemplo@email.com"
                  value="<?php echo e(old('email')); ?>"
                  required
                  aria-required="true"
                >
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="text-danger"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="text-danger"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\ProyectoFinal\sustemia\resources\views/auth/login.blade.php ENDPATH**/ ?>