<!-- start change password Modal -->
<div class="modal fade custom-modal" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModal" aria-hidden="true">
    <div class="modal-dialog custom-w-441px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h1 class="modal-title mb-0">{{ trans('modal.change_password.title') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="change-password-form">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="oldpassword" class="form-label">{{ trans('modal.change_password.old_password') }}</label>
                        <input type="password" class="form-control" name="old_password" id="old_password">
                        <span class="help-block d-none" id="old_password-error" style="color: red">{{ trans('modal.change_password.incorrect_password') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="newpassword" class="form-label">{{ trans('modal.change_password.new_password') }}</label>
                        <input type="password" class="form-control" name="new_password" id="new_password">
                    </div>
                    <div class="form-group mb-0">
                        <label for="cnewpassword" class="form-label">{{ trans('modal.change_password.c_new_password') }}</label>
                        <input type="password" class="form-control" name="c_password" id="c_password">
                    </div>
                    <button type="submit" class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold w-100 mt-30px" id="change-password-btn">
                        {{ trans('modal.button.save') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end change password  Modal -->
