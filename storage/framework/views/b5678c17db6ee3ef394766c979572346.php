<?php $__env->startSection('content'); ?>

    <div class="main">
        <div class="main-view signin-view">
            <div class="container-fluid bd-gutter bd-layout signin-layout">
                <main class="w-100">
                    <div class="main-content">
                        <div class="card signin-card">
                            <div class="card-header">
                                <h1 class="logo-text text-dark-1"><a href="javascript:void(0);">
                                        Gomeal<span class="text-yellow-1">.</span>
                                    </a></h1>
                            </div>
                            <div class="card-body signin-form">
                                <form method="POST" action="<?php echo e(route('password.update')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="token" value="<?php echo e($token); ?>">

                                    <input id="email" type="hidden"
                                           class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           name="email" value="<?php echo e($email ?? old('email')); ?>" required
                                           autocomplete="email" autofocus>

                                    <h3 class="authenticationform-title"><?php echo e(__('Forgot Password')); ?></h3>
                                    <div class="form-group">
                                        <label for="newpassword" class="form-label"><?php echo e(__('New Password')); ?></label>
                                        <input id="password" type="password"
                                               class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               name="password"
                                               required autocomplete="new-password">
                                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="form-group mb-0">
                                        <label for="newpassword"
                                               class="form-label"><?php echo e(__('Confirm New Password')); ?></label>
                                        <input id="password-confirm" type="password" class="form-control"
                                               name="password_confirmation" required autocomplete="new-password">
                                        <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <button type="submit"
                                            class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold w-100 mt-30px">
                                        Save
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <!-- start footer -->
        <script src="<?php echo e(asset('js/footer.js')); ?>"></script>
        <!-- end footer -->
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/go-meal/resources/views/auth/passwords/reset.blade.php ENDPATH**/ ?>