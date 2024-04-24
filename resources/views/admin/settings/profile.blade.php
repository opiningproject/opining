<div class="tab-pane fade" id="restaurantProfile-tab-pane" role="tabpanel" aria-labelledby="restaurantProfile-tab" tabindex="0">
    <form method="POST" id="rest-profile-form" action="{{ route('settings.save-profile') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="card-body">
            <nav class="page-breadcrumb" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">{{ trans('rest.settings.title') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">{{ trans('rest.settings.profile.title') }}</a>
                    </li>
                </ol>
            </nav>
            <div class="card-custom-body">
                <div class="row">
                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                        <div class="form-group">
                            <label for="restaurantname" class="form-label">{{ trans('rest.settings.profile.name') }}</label>
                            <input type="text" class="form-control" name="restaurant_name" maxlength="25" value="{{ $user->restaurant_name }}" required />
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                        <div class="form-group">
                            <label for="restaurantpermit" class="form-label">{{ trans('rest.settings.profile.permit_id') }}</label>
                            <input type="number" class="form-control" value="{{ $user->permit_id }}" name="permit_id" required/>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                        <div class="form-group">
                            <label for="restaurantpermit" class="form-label">{{ trans('rest.settings.profile.phone') }}</label>
                            <div class="input-group countrycode-phone-control">
                                <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ asset('images/netherlands-flag.svg') }}" alt="netherlands Flag" class="svg" height="18" width="27">
                                </button>
                                <input type="text"
                                    class="form-control countrycode-input" value="+31">
                                <input type="number" class="form-control" value="{{ $user->phone_no }}" name="phone_no" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                        <div class="form-group">
                            <label for="ownername" class="form-label">{{ trans('rest.settings.profile.owner_name') }}</label>
                            <input type="text" class="form-control" value="{{ $user->user->name }}" maxlength="25" name="owner_name" required/>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                        <div class="form-group">
                            <label for="email" class="form-label">{{ trans('rest.settings.profile.email') }}</label>
                            <input type="text" class="form-control" value="{{ $user->user->email }}" name="email" readonly />
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                        <div class="form-group">
                            <label for="addressdetail" class="form-label">{{ trans('rest.settings.profile.address_details') }}</label>
                            <input type="text" class="form-control" value="{{ $user->rest_address }}" name="rest_address" id="rest_address" required/>
                            <input type="hidden" name="latitude" id="latitude" value="{{ $user->latitude }}">
                            <input type="hidden" name="longitude" id="longitude" value="{{ $user->longitude }}">
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                        <div class="form-group ">
                            <label for="password" class="form-label">{{ trans('rest.settings.profile.password') }}</label>
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
                            <div class="form-check form-switch custom-switch d-flex align-items-center gap-3 ps-0">
                                <label class="form-check-label form-label mb-0">{{ trans('rest.settings.profile.order_acceptance') }}</label>
                                <!-- <label class="text-yellow-2 float-end form-label mb-0 text-end">Active</label> -->
                                <!-- switch online order Acceptance -->
                                <input class="form-check-input" type="checkbox" name="online_order_accept" role="switch" {{ $user->online_order_accept ? 'checked':'' }}>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                        <div class="form-group">
                            <label for="servicecharge" class="form-label">{{ trans('rest.settings.profile.logo') }}</label>
                            <label for="restaurant-logo-input-file" class="logowithtext-box">
                                <input type="file" class="d-none" id="restaurant-logo-input-file" name="image">
                                <img src="{{ $user->restaurant_logo }}" alt="" id="profile-img" class="img-fluid" />
                            </label>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                        <div class="form-group">
                            <label for="servicecharge" class="form-label">{{ trans('rest.settings.profile.footer_logo') }}</label>
                            <label for="restaurant-footer-logo-input-file" class="logowithtext-box">
                                <input type="file" class="d-none" id="restaurant-footer-logo-input-file" name="footer-img">
                                <img src="{{ $user->footer_logo }}" alt="" id="footer-img" class="img-fluid" />
                            </label>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                        <div class="form-group">
                            <label for="servicecharge" class="form-label">{{ trans('rest.settings.profile.permit_doc') }}</label>
                            <label for="permit-doc-input-file" class="logowithtext-box">
                                <input type="file" class="d-none" id="permit-doc-input-file" name="permit-doc">
                                <img src="{{ $user->permit_doc }}" alt="" id="permit-img" class="img-fluid" />
                            </label>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                        <div class="form-group">
                            <label for="servicecharge" class="form-label">{{ trans('rest.settings.profile.service_charge') }}</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">€</span>
                                <input type="number" class="form-control" value="{{ $user->service_charge }}" min="0" name="service_charge" required />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="form-group mb-0">
                            <label for="servicecharge" class="form-label">{{ trans('rest.settings.profile.opening_hours') }}</label>
                            <div class="schedule-table bg-lightgray border-custom-1 rounded-custom-12" style="font-family:'Sebino-Medium', sans-serif;font-size: 14px;">
                                <div class="row">
                                    @foreach($operating_days as $time)
                                        <div class="col-6 mb-3 d-flex justify-content-between">
                                            <div class="">
                                                {{ $time->day }}
                                            </div>
                                            <input type="hidden" value="{{ $time->id }}" name="id[]">
                                            <div class="time-day-name">
                                                <div class="form-group mb-0">
                                                    <input type="text" class="timepicker form-control time-form-control profile_start_time" id="start_time{{ $time->id }}" data-id="{{ $time->id }}" value="{{ date('H:i',strtotime($time->start_time)) }}" name="start_time[]" style="max-height: fit-content">
                                                </div>
                                                -
                                                <div class="form-group mb-0">
                                                    <input type="text" class="timepicker form-control time-form-control profile_end_time" id="end_time{{ $time->id }}" data-id="{{ $time->id }}" value="{{ date('H:i',strtotime($time->end_time)) }}" name="end_time[]" style="max-height: fit-content">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-white border-0">
            <div class="row">
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                    <button type="submit" id="profile-save-btn" class="btn btn-custom-yellow fw-400 font-sebibold w-100 mt-30px font-18">
                        {{ trans('rest.button.save') }}
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- start change password Modal -->
<div class="modal fade custom-modal" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModal" aria-hidden="true">
    <div class="modal-dialog custom-w-441px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h1 class="modal-title mb-0">{{ trans('rest.modal.change_password.title') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">
                <form method="POST" id="change-password-form">
                    <div class="form-group">
                        <label for="oldpassword" class="form-label">{{ trans('rest.modal.change_password.old_password') }}</label>
                        <input type="password" class="form-control" name="old_password" id="old_password">
                        <span class="help-block d-none" id="old_password-error" style="color: red">{{ trans('rest.modal.change_password.incorrect_password') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="newpassword" class="form-label">{{ trans('rest.modal.change_password.new_password') }}</label>
                        <input type="password" class="form-control" name="new_password" id="new_password">
                    </div>
                    <div class="form-group mb-0">
                        <label for="cnewpassword" class="form-label">{{ trans('rest.modal.change_password.c_password') }}</label>
                        <input type="password" class="form-control" name="c_password" id="c_password">
                    </div>
                    <button type="submit" class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold w-100 mt-30px" id="change-password-btn">
                        {{ trans('rest.button.save') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end change password  Modal -->

@section('script')

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCgn-yE-BywHdBacEmRH9IWEFbuaM4PWGw&libraries=places&callback=initMap" async defer></script>

    <script type="text/javascript">

        function initMap()
        {
            var input = document.getElementById('rest_address');

            var autocomplete = new google.maps.places.Autocomplete(input);

            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
                $('#latitude').val(place.geometry.location.lat());
                $('#longitude').val(place.geometry.location.lng());
            });
        }
    </script>
@endsection
