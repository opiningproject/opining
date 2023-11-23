<form method="POST" id="rest-profile-form" action="{{ route('settings.save-profile') }}">
  {{ csrf_field() }}
  <div class="tab-pane fade show active" id="restaurantProfile-tab-pane" role="tabpanel" aria-labelledby="restaurantProfile-tab" tabindex="0">
    <div class="card-body">
      <nav class="page-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Settings</a>
          </li>
          <li class="breadcrumb-item">
            <a href="#">Restaurant Profile</a>
          </li>
          <li class="breadcrumb-item active">Edit Restaurant Profile</li>
        </ol>
      </nav>
      <div class="card-custom-body">
        <div class="row">
          <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
            <div class="form-group">
              <label for="restaurantname" class="form-label">Restaurant Name</label>
              <input type="text" class="form-control" name="restaurant_name" value="{{ $user->restaurant_name }}" required />
            </div>
          </div>
          <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
            <div class="form-group">
              <label for="restaurantpermit" class="form-label">Restaurant Permit ID</label>
              <input type="number" class="form-control" value="{{ $user->permit_id }}" name="permit_id" required/>
            </div>
          </div>
          <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
            <div class="form-group">
              <label for="restaurantpermit" class="form-label">Phone</label>
              <div class="countrycode-phone-control position-relative">
                <img src="images/netherlands-flag.svg" alt="netherlands Flag" class="img-fluid">
                <input type="number" class="form-control" value="{{ $user->phone_no }}" name="phone_no" required>
              </div>
            </div>
          </div>
          <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
            <div class="form-group">
              <label for="ownername" class="form-label">Owner Name</label>
              <input type="text" class="form-control" value="{{ $user->user->first_name.' '.$user->user->last_name }}" name="owner_name" required/>
            </div>
          </div>
          <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
            <div class="form-group">
              <label for="email" class="form-label">Email</label>
              <input type="text" class="form-control" value="{{ $user->user->email }}" name="email" readonly />
            </div>
          </div>
          <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
            <div class="form-group">
              <label for="addressdetail" class="form-label">Address Details</label>
              <input type="text" class="form-control" value="{{ $user->rest_address }}" name="rest_address" required/>
              <input type="hidden" name="latitude" id="latitude" value="{{ $user->latitude }}">
              <input type="hidden" name="longitude" id="longitude" value="{{ $user->longitude }}">
            </div>
          </div>
          <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
            <div class="form-group ">
              <label for="password" class="form-label">Password</label>
              <div class="input-group">
                <input type="password" class="form-control" value="12345678" readonly />
                <button class="input-group-btn btn btn-custom-yellow btn-icon h-50px" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                  <i class="fa-solid fa-pen-to-square"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 my-auto">
            <div class="form-group mb-0 mt-2">
              <div class="form-check form-switch custom-switch d-flex align-items-center justify-content-between ps-0">
                <label class="form-check-label form-label mb-0">Online Order Acceptance</label>
                <!-- <label class="text-yellow-2 float-end form-label mb-0 text-end">Active</label> -->
                <!-- switch online order Acceptance -->
                <input class="form-check-input" type="checkbox" name="online_order_accept" role="switch" {{ $user->online_order_accept ? 'checked':'' }}>
              </div>
            </div>
          </div>
          <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
            <div class="form-group">
              <label for="servicecharge" class="form-label">Restaurant Logo</label>
              <div class="logowithtext-box">
                <img src="images/restaurantlogo-img.svg" alt="Restaurant Logo" class="img-fluid" />
                <span class="lead-3 text-custom-muted">Lorem Ipsum.png</span>
              </div>
            </div>
          </div>
          <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
            <div class="form-group">
              <label for="servicecharge" class="form-label">Company Permit Document</label>
              <div class="logowithtext-box">
                <img src="images/restaurantlogo-img.svg" alt="Restaurant Logo" class="img-fluid" />
                <span class="lead-3 text-custom-muted">Lorem Ipsum.png</span>
              </div>
            </div>
          </div>
          <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
            <div class="form-group">
              <label for="servicecharge" class="form-label">service charge</label>
              <div class="input-group">
                <span class="input-group-text" id="basic-addon1">€</span>
                <input type="number" class="form-control" value="{{ $user->service_charge }}" name="service_charge" required />
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
            <div class="form-group mb-0">
              <label for="servicecharge" class="form-label">Restaurant Opening Hours</label>
              <div class="schedule-table bg-lightgray border-custom-1 rounded-custom-12">
                <table class="table table-borderless mb-0">
                  <tbody>
                    <tr>
                      <td>Monday</td>
                      <td>
                        <div class="time-day-name">
                          <div class="form-group mb-0">
                            <input type="text" class="timepicker form-control time-form-control" value="12:00" />
                          </div> - <div class="form-group mb-0">
                            <input type="text" class="timepicker form-control time-form-control" value="22:00" />
                          </div>
                        </div>
                      </td>
                      <td>Friday</td>
                      <td class="text-end">
                        <div class="time-day-name">
                          <div class="form-group mb-0">
                            <input type="text" class="timepicker form-control time-form-control" value="12:00" />
                          </div> - <div class="form-group mb-0">
                            <input type="text" class="timepicker form-control time-form-control" value="22:00" />
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Tuesday</td>
                      <td>
                        <div class="time-day-name">
                          <div class="form-group mb-0">
                            <input type="text" class="timepicker form-control time-form-control" value="12:00" />
                          </div> - <div class="form-group mb-0">
                            <input type="text" class="timepicker form-control time-form-control" value="22:00" />
                          </div>
                        </div>
                      </td>
                      <td>Saturday</td>
                      <td class="text-end">
                        <div class="time-day-name">
                          <div class="form-group mb-0">
                            <input type="text" class="timepicker form-control time-form-control" value="12:00" />
                          </div> - <div class="form-group mb-0">
                            <input type="text" class="timepicker form-control time-form-control" value="22:00" />
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Wednesday</td>
                      <td>
                        <div class="time-day-name">
                          <div class="form-group mb-0">
                            <input type="text" class="timepicker form-control time-form-control" value="12:00" />
                          </div> - <div class="form-group mb-0">
                            <input type="text" class="timepicker form-control time-form-control" value="22:00" />
                          </div>
                        </div>
                      </td>
                      <td>Sunday</td>
                      <td class="text-end">
                        <div class="time-day-name">
                          <div class="form-group mb-0">
                            <input type="text" class="timepicker form-control time-form-control" value="12:00" />
                          </div> - <div class="form-group mb-0">
                            <input type="text" class="timepicker form-control time-form-control" value="22:00" />
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="pb-0">Thursday</td>
                      <td class="pb-0">
                        <div class="time-day-name">
                          <div class="form-group mb-0">
                            <input type="text" class="timepicker form-control time-form-control" value="12:00" />
                          </div> - <div class="form-group mb-0">
                            <input type="text" class="timepicker form-control time-form-control" value="22:00" />
                          </div>
                        </div>
                      </td>
                      <td></td>
                      <td class="text-end pb-0">
                        <div class="time-day-name"></div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card-footer bg-white border-0">
      <div class="row">
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
          <a class="btn btn-custom-yellow btn-default d-block">
            <!-- <span class="align-middle">Save</span> -->
            <button type="submit" class="align-middle" id="profile-save-btn">Save</button>
          </a>
        </div>
      </div>
    </div>
  </div>
</form>

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
                        <input type="text" class="form-control" name="old_password" id="old_password" required>
                        <span class="help-block d-none" id="old_password-error">Old password is not correct</span>
                    </div>
                    <div class="form-group">
                        <label for="newpassword" class="form-label">New Password</label>
                        <input type="text" class="form-control" name="new_password" id="new_password" min="8" required>
                        <span class="help-block d-none" id="c_password-error">Confirm password does not match with password</span>
                    </div>
                    <div class="form-group mb-0">
                        <label for="cnewpassword" class="form-label">Confirm New Password</label>
                        <input type="text" class="form-control" name="c_password" id="c_password" min="8" required>
                    </div>
                    <button type="submit" class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold w-100 mt-30px" id="change-password-btn">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end change password  Modal -->