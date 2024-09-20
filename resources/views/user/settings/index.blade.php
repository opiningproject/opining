@extends('layouts.user-app')
@section('content')
<div class="main">
  <div class="main-view">
    <div class="container-fluid bd-gutter bd-layout">
        @include('layouts.user.side_nav_bar')
        <main class="bd-main order-1">
            <div class="main-content">
              <div class="section-page-title main-page-title mb-0 align-items-start title-mobile">
                <div class="col-xxl-6 col-xl-6 col-lg-5 col-md-6 col-sm-6 col-12">
                <h1 class="page-title">{{ trans('user.profile.title') }}</h1>
              </div>
              </div>
              <!-- start profile section -->
              <section class="custom-section profile-section h-100 pb-0 pt-2">
                <div class="card custom-card h-100 shadow-mobile">
                  <form class="form" id="user-profile-form" action="{{ route('user.settings.save-profile') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="card-body">
                      <div class="row">
                        <div class="col-12 custom-w-col-15">
                          <div class="form-group">
                            <img src="{{ $user->image }}" class="img-thumbnail profile-image" alt="profile image" width="120" height="120">
                          </div>
                        </div>
                        <div class="col-lg-8 col-xl-6 col-xxl-3 col-12 lg-my-auto custom-w-col-fileupload mb-4">
                          <input name="image" id="image" type="file" accept="image/png, image/gif, image/jpeg" class="file-upload-field form-control form-control-lg" value="" />
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                          <div class="form-group">
                            <label for="firstname" class="form-label">{{ trans('user.profile.first_name') }}</label>
                            <input type="text" class="form-control" name="first_name" maxlength="15" value="{{ $user->first_name }}" required />
                          </div>
                        </div>
                        <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                          <div class="form-group">
                            <label for="lastname" class="form-label">{{ trans('user.profile.last_name') }}</label>
                            <input type="text" class="form-control" name="last_name" maxlength="15" value="{{ $user->last_name }}" required />
                          </div>
                        </div>
                        <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                          <div class="form-group">
                            <label for="ownername" class="form-label">{{ trans('user.profile.dob') }}</label>
                            <div class="input-group dateselect-group date">
                              <span class="input-group-text" id="basic-addon1">
                                <img src="{{ asset('images/calender-icon-up.svg') }}" alt="" width="20" height="20" class="svg">
                              </span>
                              <input type="text" class="form-control" id="dob" aria-label="dob" aria-describedby="basic-addon1" value="{{ $user->dob }}" name="dob" required readonly>
                            </div>
                          </div>
                        </div>
                        <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                          <div class="form-group">
                            <label for="restaurantpermit" class="form-label">{{ trans('user.profile.phone') }}</label>
                            <div class="input-group countrycode-phone-control">
                              <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ asset('images/netherlands-flag.svg') }}" alt="netherlands Flag" class="img-fluid">
                              </button>
                              <input type="text" class="form-control countrycode-input" readonly value="+31">
                              <input type="number" class="form-control" value="{{ $user->phone_no }}" name="phone_no" maxlength="9" minlength="9" min="1" required>
                            </div>
                          </div>
                        </div>
                        <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                          <div class="form-group">
                            <label for="email" class="form-label">{{ trans('user.profile.email') }}</label>
                            <input type="email" class="form-control" value="{{ $user->email }}" name="email" readonly />
                          </div>
                        </div>
                        <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                          <div class="form-group ">
                            <label for="password" class="form-label">{{ trans('user.profile.password') }}</label>
                            <div class="input-group">
                              <input type="password" class="form-control" value="12345678" readonly />
                              <button class="input-group-btn btn btn-site-theme btn-icon h-50px" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                <i class="fa-solid fa-pen-to-square"></i>
                              </button>
                            </div>
                          </div>
                        </div>
                        <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                          <div class="form-group">
                            <label for="gender" class="form-label">{{ trans('user.profile.gender') }}</label>
                            <select class="form-select form-select-lg" aria-label=".form-select-lg example" id="gender" name="gender" required>
                              <option value="" {{ !$user->gender ? 'selected' : ''}}>{{ trans('user.profile.select') }}</option>
                              <option value="1" {{ $user->gender == '1' ? 'selected' : ''}}>{{ trans('user.profile.male') }} </option>
                              <option value="2" {{ $user->gender == '2' ? 'selected' : ''}}>{{ trans('user.profile.female') }} </option>
                              <option value="3" {{ $user->gender == '3' ? 'selected' : ''}}>{{ trans('user.profile.other') }} </option>
                            </select>
                          </div>
                        </div>
                          <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                              <div class="form-group">
                                  <label for="language" class="form-label">{{ trans('user.profile.language') }}</label>
                                  <div class="custom-select-wrapper">
                                      <div class="custom-select">
                                          <div class="custom-select-trigger dropdown-toggle form-control">
                                              <span>
                                                    <img
                                                        src="{{ App::isLocale('nl') ? asset('images/dutch-flag.svg') : asset('images/english-flag.svg') }}"
                                                        width="20" height="20" alt="flag"/>
                                                    {{ App::isLocale('nl') ? 'Dutch' : 'English' }}
                                                </span>
                                              <div class="arrow"></div>
                                          </div>
                                          <div class="custom-options">
                                                <span class="custom-option {{ App::isLocale('en') ? 'selected' : '' }}"
                                                      data-value="en">
                                                    <img src="{{ asset('images/english-flag.svg') }}" width="20"
                                                         height="20" alt="English flag"> English
                                                </span>
                                              <span class="custom-option {{ App::isLocale('nl') ? 'selected' : '' }}"
                                                    data-value="nl">
                                                    <img src="{{ asset('images/dutch-flag.svg') }}" width="20"
                                                         height="20" alt="Dutch flag"> Dutch
                                                </span>
                                          </div>
                                      </div>
                                      <select id="language" name="language" required style="display: none;">
                                          <option value="en" {{ App::isLocale('en') ? 'selected' : '' }}>English</option>
                                          <option value="nl" {{ App::isLocale('nl') ? 'selected' : '' }}>Dutch</option>
                                      </select>
                                  </div>
                              </div>
                          </div>

                      </div>
                      <div class="row">
                        <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                          <button type="submit" class="align-middle btn btn-site-theme btn-default d-block w-100" id="profile-save-btn">{{ trans('user.button.save') }}</button>
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
  $(function() {
    $('#dob').datepicker({
      endDate: '-18y',
      format: 'dd-mm-yyyy',
      autoclose: true,
      orientation: "bottom left",
    });
  });

  // language dropdown code
  $(document).ready(function() {
      $('.custom-select-trigger').on('click', function() {
          $(this).siblings('.custom-options').toggle();
      });

      $('.custom-option').on('click', function() {
          var value = $(this).data('value');
          var text = $(this).html();
          $('.custom-select-trigger span').html(text);
          $('#language').val(value).change();
          $('.custom-options').hide();
          $('.custom-option').removeClass('selected');
          $(this).addClass('selected');
          if (value == "en") {
              window.location.href = "{{ route('app.setLocal', 'en') }}";
          } else if(value == "nl") {
              window.location.href = "{{ route('app.setLocal', 'nl') }}";
          }
      });

      // Close dropdown when clicking outside
      $(document).click(function(e) {
          if (!$(e.target).closest('.custom-select').length) {
              $('.custom-options').hide();
          }
      });

  });

</script>
@endsection
