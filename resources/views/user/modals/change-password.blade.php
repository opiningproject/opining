<!-- start change password Modal -->
<div class="modal fade custom-modal" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModal" aria-hidden="true">
    <div class="modal-dialog custom-w-441px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h1 class="modal-title mb-0">Change Password</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">
                <form method="POST" id="change-password-form">
                    <div class="form-group">
                        <label for="oldpassword" class="form-label">Old Password</label>
                        <input type="text" class="form-control" name="old_password" id="old_password">
                        <span class="help-block d-none" id="old_password-error">Old password is not correct</span>
                    </div>
                    <div class="form-group">
                        <label for="newpassword" class="form-label">New Password</label>
                        <input type="text" class="form-control" name="new_password" id="new_password">
                        <span class="help-block d-none" id="c_password-error">Confirm password does not match with password</span>
                    </div>
                    <div class="form-group mb-0">
                        <label for="cnewpassword" class="form-label">Confirm New Password</label>
                        <input type="text" class="form-control" name="c_password" id="c_password">
                    </div>
                    <button type="submit" class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold w-100 mt-30px" id="change-password-btn">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end change password  Modal -->
