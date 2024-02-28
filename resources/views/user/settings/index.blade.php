@extends('layouts.user-app')

@section('content')
    <div class="main">
        <div class="main-view">
            <div class="container-fluid bd-gutter bd-layout">
                @include('layouts.user.side_nav_bar')
                <main class="bd-main order-1">
                    <div class="main-content">
                        <div class="section-page-title main-page-title mb-0">
                            <h1 class="page-title">Profile</h1>
                        </div>
                        <!-- start profile section -->
                        <section class="custom-section profile-section h-100">
                            <div class="card custom-card h-100">
                                <form class="form" id="user-profile-form"
                                      action="{{ route('user.settings.save-profile') }}" method="POST"
                                      enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="card-body ">
                                        <div class="row">
                                            <div
                                                class="col-xxl-12 col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12 custom-w-col-15">
                                                <div class="form-group">
                                                    <img src="{{ $user->image }}" class="img-thumbnail profile-image"
                                                         alt="profile image" width="120" height="120">
                                                </div>
                                            </div>
                                            <div
                                                class="col-xxl-3 col-xl-5 col-lg-4 col-md-6 col-sm-12 col-12 lg-my-auto custom-w-col-fileupload">
                                                <div class="form-group">
                                                    <div class="file-upload-wrapper form-control" data-text="Upload">
                                                        <input name="image" id="image" type="file" accept="image/png, image/gif, image/jpeg"
                                                               class="file-upload-field" value="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label for="firstname" class="form-label">First Name</label>
                                                    <input type="text" class="form-control" name="first_name"
                                                           maxlength="15" value="{{ $user->first_name }}" required/>
                                                </div>
                                            </div>
                                            <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label for="lastname" class="form-label">Last Name</label>
                                                    <input type="text" class="form-control" name="last_name"
                                                           maxlength="15" value="{{ $user->last_name }}" required/>
                                                </div>
                                            </div>
                                            <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label for="ownername" class="form-label">Date of Birth</label>
                                                    <div class="input-group dateselect-group date">
                        <span class="input-group-text" id="basic-addon1">
                          <img src="{{ asset('images/calender-icon.svg') }}" alt="" width="20" height="20" class="svg">
                        </span>
                                                        <input type="text" class="form-control" id="dob"
                                                               aria-label="dob" aria-describedby="basic-addon1" value="{{ $user->dob }}"
                                                               name="dob" required readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label for="restaurantpermit" class="form-label">Phone</label>
                                                    <div class="input-group countrycode-phone-control">
                                                        <button class="dropdown-toggle" type="button"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                            <img src="{{ asset('images/netherlands-flag.svg') }}"
                                                                 alt="netherlands Flag" class="img-fluid">
                                                        </button>

                                                        <input type="text" class="form-control countrycode-input"
                                                               readonly value="+31">
                                                        <input type="number" class="form-control"
                                                               value="{{ $user->phone_no }}" name="phone_no"
                                                               maxlength="9" minlength="9" min="1" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" value="{{ $user->email }}"
                                                           name="email" readonly/>
                                                </div>
                                            </div>
                                            <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12">
                                                <div class="form-group ">
                                                    <label for="password" class="form-label">Password</label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" value="12345678"
                                                               readonly/>
                                                        <button
                                                            class="input-group-btn btn btn-custom-yellow btn-icon h-50px"
                                                            type="button" id="button-addon2" data-bs-toggle="modal"
                                                            data-bs-target="#changePasswordModal">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label for="gender" class="form-label">Gender</label>
                                                    <select class="form-select form-select-lg"
                                                            aria-label=".form-select-lg example" id="gender"
                                                            name="gender" required>
                                                        <option value="" {{ !$user->gender ? 'selected':''}} >Please
                                                            select
                                                        </option>
                                                        <option value="1" {{ $user->gender=='1' ? 'selected':''}} >
                                                            Male
                                                        </option>
                                                        <option value="2" {{ $user->gender=='2' ? 'selected':''}} >
                                                            Female
                                                        </option>
                                                        <option value="3" {{ $user->gender=='3' ? 'selected':''}} >
                                                            Other
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12">
                                                <button type="submit"
                                                        class="align-middle btn btn-custom-yellow btn-default d-block w-100"
                                                        id="profile-save-btn">Save
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </section>
                        <!-- end profile section -->
                    </div>
                </main>
            </div>
        </div>
        <!-- start footer -->
    @include('layouts.user.footer_design')
    <!-- end footer -->
    </div>

    @include('user.modals.change-password')

@endsection

@section('script')
    <script>

        $(function () {
            $('#dob').datepicker({
                endDate :'-18y',
                format: 'dd-mm-yyyy',
                autoclose: true,
                orientation: "bottom left",
            });

        });

    </script>
@endsection
