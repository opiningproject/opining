<?php $__env->startSection('content'); ?>
<div class="main" style="min-height: 100vh;">
    <div class="main-view signin-view">
        <div class="container-fluid bd-gutter bd-layout signin-layout py-3">
            <main class="w-100">
                <div class="main-content">
                    <div class="card signin-card">
                        <div class="card-header">
                            <div class="logo-text text-dark-1 mb-0">
                                <a href="javascript:void(0);">
                                    <div>
                                        <img src="<?php echo e(asset('images/logo-admin.png')); ?>" class="web-logo">
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="card-body signin-form">
                            <form method="POST" action="<?php echo e(route('login')); ?>">
                                <?php echo csrf_field(); ?>
                                <div class="mb-3">
                                    <div
                                        class="form-group prev-input-group mb-0 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <span class="input-group-icon">
                                        <img src="<?php echo e(asset('images/mail-icon2-up.svg')); ?>" class="svg" width="18" height="12">

                                    </span>
                                        <input type="text" class="form-control ps-5 text-indent-initial" autocomplete="off" name="email" placeholder="<?php echo e(trans('rest.auth.email')); ?>" value="<?php echo e(old('email')); ?>">
                                    </div>
                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback" role="alert">
                                        <?php echo e($message); ?>

                                    </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="mb-3">
                                    <div class="form-group mb-0 prev-input-group <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <span class="input-group-icon">
                                            <img src="<?php echo e(asset('images/password-icon-up.svg')); ?>" class="svg" width="15" height="20">
                                        </span>

                                        <input type="password" class="form-control ps-5 text-indent-initial" name="password" placeholder="<?php echo e(trans('rest.auth.password')); ?>" id="password"  value="<?php echo e(old('password')); ?>" autocomplete="off">

                                        <span class="input-group-icon passwordeye-icon view-pwd-icon">
                                            <img src="<?php echo e(asset('images/passwordeye-icon.svg')); ?>" class="svg d-none show-password"  width="21" height="19"/>
                                            <img src="<?php echo e(asset('images/passwordeye-open.svg')); ?>"  class="svg hide-password"  width="21" height="19"/>
                                        </span>
                                    </div>
                                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback" role="alert">
                                        <?php echo e($message); ?>

                                    </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="input-group justify-content-end text-end">
                                    <?php if(Route::has('password.request')): ?>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#resendPasswordModal" class="text-capitalize lead-2 font-regularcustom">
                                            <?php echo e(trans('rest.auth.forgot_password')); ?>

                                        </a>
                                    <?php endif; ?>
                                </div>

                                <button type="submit"
                                        class="btn btn-site-theme fw-400 text-uppercase font-sebibold w-100 signin-btn">
                                    <?php echo e(trans('rest.button.login')); ?>

                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <div class="modal fade loginscreen-modal custom-modal" id="resendPasswordModal" tabindex="-1"
         aria-labelledby="resendPasswordModal" aria-hidden="true">
        <div class="modal-dialog custom-w-441px resendpwdmodal">
            <div class="modal-content">
                <div class="modal-header border-0 justify-content-center">
                    <img src="<?php echo e(getRestaurantDetail()->restaurant_logo); ?>" class="web-logo">
                </div>
                <div class="modal-body signin-form">
                    <form method="POST" id="reset-pwd-form" action="javascript:void(0)">
                        <?php echo csrf_field(); ?>
                        <h3 class="authenticationform-title"><?php echo e(trans('rest.auth.reset_password')); ?></h3>
                        <div class="form-group prev-input-group mb-0">
                        <span class="input-group-icon">
                            <img src="<?php echo e(asset('images/mail-icon2-up.svg')); ?>" class="svg" width="18" height="12">
                        </span>
                            <input type="text" name="forgot-pwd-email" id="forgot-pwd-email" class="form-control text-indent-initial ps-5" placeholder="<?php echo e(trans('modal.auth.email')); ?>" value="" autocomplete="email" autofocus>
                        </div>

                        <span class="invalid-feedback" role="alert" style="display:block">
                            <p class="mb-0" id="forgot-pwd-error-msg"></p>
                        </span>

                        <span class="invalid-feedback" role="alert" style="display:block; color: #0f5132">
                            <p class="mb-0" id="forgot-pwd-success-msg"></p>
                        </span>

                        <button type="submit" id="forgot-pwd--submit-btn" class="btn btn-site-theme fw-400 text-uppercase font-sebibold w-100 mt-30px">
                            <?php echo e(trans('rest.button.send_password_link')); ?>

                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script type="text/javascript">
        $(function () {
            $(document).on('click', '#forgot-pwd--submit-btn', function () {
                var email = $('#forgot-pwd-email').val()
                $.ajax({
                    url: '<?php echo e(route('password.email')); ?>',
                    type: 'post',
                    data: {
                        email
                    },
                    success: function (response) {
                        $('#forgot-pwd-email').removeClass('is-invalid')
                        $('#forgot-pwd-error-msg').text('')
                        $('#forgot-pwd-success-msg').text(response.message)
                    },
                    error: function (response) {
                        var errorMessage = JSON.parse(response.responseText).message
                        $('#forgot-pwd-error-msg').text(errorMessage)
                        $('#forgot-pwd-email').addClass('is-invalid').val(email)
                    }
                })
            })

            $(document).on('click', '.view-pwd-icon', function () {
                if ($('#password').attr('type') == 'text') {
                    $('#password').attr('type', 'password')
                } else {
                    $('#password').attr('type', 'text')
                }

                $('.hide-password').toggleClass('d-none');
                $('.show-password').toggleClass('d-none');
            })

            $('#resendPasswordModal').on('hidden.bs.modal', function () {
                var alertas = $('#reset-pwd-form');
                alertas.trigger("reset");
                $('#forgot-pwd-error-msg').text('')
                $('#forgot-pwd-success-msg').text('')
                $('#forgot-pwd-email').removeClass('is-invalid')
            });
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\wamp\www\go-meal\resources\views/auth/login.blade.php ENDPATH**/ ?>