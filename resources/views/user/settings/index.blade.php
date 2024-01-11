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
              <form class="form" id="user-profile-form" action="{{ route('user.settings.save-profile') }}" method="POST">
              {{ csrf_field() }}
              <div class="card-body pb-0 ">
                <div class="row">
                  <div class="col-xxl-12 col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12 custom-w-col-15">
                    <div class="form-group">
                      <img src="{{ asset('images/profile-img.png') }}" class="img-thumbnail profile-image" alt="profile image" width="120" height="120">
                    </div>
                  </div>
                  <div class="col-xxl-3 col-xl-5 col-lg-4 col-md-6 col-sm-12 col-12 lg-my-auto custom-w-col-fileupload">
                    <div class="form-group">

                        <div class="file-upload-wrapper form-control" data-text="Upload">
                          <input name="file-upload-field" type="file" class="file-upload-field" value="">
                        </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                      <label for="firstname" class="form-label">First Name</label>
                      <input type="text" class="form-control" name="first_name" value="{{ $user->first_name }}" required />
                    </div>
                  </div>
                  <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                      <label for="lastname" class="form-label">Last Name</label>
                      <input type="text" class="form-control" name="last_name" value="{{ $user->last_name }}" required/>
                    </div>
                  </div>
                  <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                      <label for="ownername" class="form-label">Date of Birth</label>
                      <div class="input-group dateselect-group date">
                        <span class="input-group-text" id="basic-addon1">
                          <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19" fill="none">
                            <g clip-path="url(#clip0_1830_17479)">
                              <path d="M3.11839 1.46913C3.11839 0.957162 3.11839 0.49713 3.11839 0.00741986C3.62294 0.00741986 4.09039 0.00741986 4.59494 0.00741986C4.59494 0.482291 4.59494 0.949742 4.59494 1.43945C7.8671 1.43945 11.1096 1.43945 14.3892 1.43945C14.3892 0.964582 14.3892 0.489711 14.3892 0C14.8937 0 15.3612 0 15.8657 0C15.8657 0.474871 15.8657 0.949742 15.8657 1.46913C16.1848 1.46913 16.4667 1.46913 16.7487 1.46913C18.0175 1.48397 18.9895 2.43371 18.9969 3.69509C19.0043 8.04313 19.0043 12.3986 18.9969 16.7466C18.9969 18.008 18.0249 18.9726 16.7561 18.9726C11.9258 18.98 7.08802 18.98 2.25769 18.9726C0.974053 18.9726 0.00947114 18.0006 0.00947114 16.7095C0.00205129 12.3837 0.00205129 8.05797 0.00947114 3.73219C0.00947114 2.42629 0.981473 1.47655 2.29479 1.46913C2.54706 1.46171 2.80676 1.46913 3.11839 1.46913ZM17.5129 6.98209C12.1484 6.98209 6.82832 6.98209 1.48602 6.98209C1.48602 7.11564 1.48602 7.22694 1.48602 7.33824C1.48602 10.4026 1.48602 13.467 1.48602 16.5389C1.48602 17.2437 1.7383 17.4886 2.4506 17.4886C7.14738 17.4886 11.8441 17.4886 16.5483 17.4886C17.2606 17.4886 17.5129 17.2437 17.5129 16.5389C17.5129 13.9642 17.5129 11.3969 17.5129 8.82221C17.5129 8.2212 17.5129 7.61277 17.5129 6.98209ZM1.49344 5.44618C6.858 5.44618 12.178 5.44618 17.5129 5.44618C17.5129 4.83775 17.5203 4.259 17.5129 3.68025C17.5055 3.31668 17.2977 3.04956 16.949 2.9902C16.6077 2.93826 16.2515 2.97536 15.8731 2.97536C15.8731 3.47991 15.8731 3.93994 15.8731 4.4074C15.3686 4.4074 14.8937 4.4074 14.3966 4.4074C14.3966 3.91769 14.3966 3.45023 14.3966 2.97536C11.1244 2.97536 7.88194 2.97536 4.60236 2.97536C4.60236 3.47249 4.60236 3.94736 4.60236 4.42224C4.09781 4.42224 3.63036 4.42224 3.12581 4.42224C3.12581 3.93252 3.12581 3.45765 3.12581 2.96052C2.79192 2.96052 2.49512 2.94568 2.19833 2.96052C1.8125 2.98278 1.5157 3.26474 1.50828 3.65057C1.4786 4.23674 1.49344 4.83033 1.49344 5.44618Z" fill="#FFC00B" />
                              <path d="M2.85156 8.53125C3.34127 8.53125 3.80872 8.53125 4.29102 8.53125C4.29102 9.01354 4.29102 9.47357 4.29102 9.9707C3.82356 9.9707 3.35611 9.9707 2.85156 9.9707C2.85156 9.50325 2.85156 9.0358 2.85156 8.53125Z" fill="#FFC00B" />
                              <path d="M7.25977 9.98594C6.77005 9.98594 6.3026 9.98594 5.82031 9.98594C5.82031 9.50364 5.82031 9.02877 5.82031 8.53906C6.3026 8.53906 6.77005 8.53906 7.25977 8.53906C7.25977 9.01393 7.25977 9.48139 7.25977 9.98594Z" fill="#FFC00B" />
                              <path d="M8.77734 8.53125C9.25963 8.53125 9.72709 8.53125 10.2168 8.53125C10.2168 9.00612 10.2168 9.48099 10.2168 9.97812C9.74192 9.97812 9.27447 9.97812 8.77734 9.97812C8.77734 9.50325 8.77734 9.0358 8.77734 8.53125Z" fill="#FFC00B" />
                              <path d="M11.7461 9.97852C11.7461 9.49622 11.7461 9.02877 11.7461 8.53906C12.221 8.53906 12.6958 8.53906 13.193 8.53906C13.193 9.01393 13.193 9.48138 13.193 9.97852C12.7181 9.97852 12.2506 9.97852 11.7461 9.97852Z" fill="#FFC00B" />
                              <path d="M16.1543 9.97852C15.6646 9.97852 15.1971 9.97852 14.7148 9.97852C14.7148 9.49622 14.7148 9.03619 14.7148 8.53906C15.1823 8.53906 15.6572 8.53906 16.1543 8.53906C16.1543 9.00651 16.1543 9.48138 16.1543 9.97852Z" fill="#FFC00B" />
                              <path d="M4.29102 11.5078C4.29102 12.0049 4.29102 12.4724 4.29102 12.9547C3.80872 12.9547 3.34127 12.9547 2.85156 12.9547C2.85156 12.4798 2.85156 12.0124 2.85156 11.5078C3.31901 11.5078 3.79388 11.5078 4.29102 11.5078Z" fill="#FFC00B" />
                              <path d="M7.25977 12.9547C6.77747 12.9547 6.31002 12.9547 5.82031 12.9547C5.82031 12.4798 5.82031 12.0049 5.82031 11.5078C6.29518 11.5078 6.77005 11.5078 7.25977 11.5078C7.25977 11.9827 7.25977 12.4427 7.25977 12.9547Z" fill="#FFC00B" />
                              <path d="M8.77734 11.5C9.25963 11.5 9.71967 11.5 10.2168 11.5C10.2168 11.9749 10.2168 12.4423 10.2168 12.9469C9.74934 12.9469 9.27447 12.9469 8.77734 12.9469C8.77734 12.4646 8.77734 11.9897 8.77734 11.5Z" fill="#FFC00B" />
                              <path d="M13.2004 11.5156C13.2004 12.0053 13.2004 12.4579 13.2004 12.9402C12.7181 12.9402 12.2432 12.9402 11.7461 12.9402C11.7461 12.4728 11.7461 11.9979 11.7461 11.5156C12.2358 11.5156 12.7181 11.5156 13.2004 11.5156Z" fill="#FFC00B" />
                              <path d="M14.707 12.9398C14.707 12.4576 14.707 11.9975 14.707 11.5078C15.1893 11.5078 15.6642 11.5078 16.1613 11.5078C16.1613 11.9827 16.1613 12.4427 16.1613 12.9398C15.6939 12.9398 15.219 12.9398 14.707 12.9398Z" fill="#FFC00B" />
                              <path d="M2.83594 15.916C2.83594 15.4337 2.83594 14.9663 2.83594 14.4766C3.31081 14.4766 3.78568 14.4766 4.28281 14.4766C4.28281 14.9514 4.28281 15.4263 4.28281 15.916C3.80794 15.916 3.34791 15.916 2.83594 15.916Z" fill="#FFC00B" />
                              <path d="M5.8125 14.4688C6.30221 14.4688 6.76224 14.4688 7.25195 14.4688C7.25195 14.9436 7.25195 15.4185 7.25195 15.9156C6.77708 15.9156 6.30221 15.9156 5.8125 15.9156C5.8125 15.4408 5.8125 14.9733 5.8125 14.4688Z" fill="#FFC00B" />
                              <path d="M8.76562 15.9164C8.76562 15.4267 8.76562 14.9667 8.76562 14.4844C9.2405 14.4844 9.71537 14.4844 10.2199 14.4844C10.2199 14.9444 10.2199 15.4193 10.2199 15.9164C9.74505 15.9164 9.2776 15.9164 8.76562 15.9164Z" fill="#FFC00B" />
                              <path d="M13.1934 14.4766C13.1934 14.9663 13.1934 15.4337 13.1934 15.916C12.7111 15.916 12.251 15.916 11.7539 15.916C11.7539 15.4486 11.7539 14.9737 11.7539 14.4766C12.2214 14.4766 12.6962 14.4766 13.1934 14.4766Z" fill="#FFC00B" />
                            </g>
                            <defs>
                              <clipPath id="clip0_1830_17479">
                                <rect width="19.0023" height="18.98" fill="white" />
                              </clipPath>
                            </defs>
                          </svg>
                        </span>
                        <input type="text" class="form-control" id="dob" aria-label="dob" aria-describedby="basic-addon1" name="dob" value="{{ $user->dob }}" required readonly>
                      </div>
                    </div>
                  </div>
                  <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12">
                    <!-- <div class="form-group">
                      <label for="restaurantpermit" class="form-label">Phone</label>
                      <div class="countrycode-phone-control position-relative">
                        <img src="{{ asset('images/netherlands-flag.svg') }}" alt="netherlands Flag" class="img-fluid">
                        <input type="text" class="form-control" value="{{ $user->phone_no }}" name="phone_no" required>
                      </div>
                    </div> -->
                    <div class="form-group">
                        <label for="restaurantpermit" class="form-label">Phone</label>
                        <div class="input-group countrycode-phone-control">
                            <div class="dropdown">
                              <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                  <img src="{{ asset('images/netherlands-flag.svg') }}" alt="netherlands Flag" class="img-fluid">
                              </button>
                              <ul class="dropdown-menu">
                                  <li>
                                    <button class="dropdown-item" type="button">
                                      <img src="{{ asset('images/netherlands-flag.svg') }}" alt="netherlands Flag" class="img-fluid">
                                    </button>
                                  </li>
                              </ul>
                            </div>
                            <input type="text" class="form-control countrycode-input" value="+31">
                            <input type="number" class="form-control" value="{{ $user->phone_no }}" name="phone_no" required>
                        </div>
                    </div>
                  </div>
                  <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                      <label for="email" class="form-label">Email</label>
                      <input type="email" class="form-control" value="{{ $user->email }}" name="email" readonly  />
                    </div>
                  </div>
                  <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12">
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
                  <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                      <label for="gender" class="form-label">Gender</label>
                      <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" id="gender" name="gender" required>
                        <option value="" {{ !$user->gender ? 'selected':''}} >Please select</option>
                        <option value="1" {{ $user->gender=='1' ? 'selected':''}} >Male</option>
                        <option value="2" {{ $user->gender=='2' ? 'selected':''}} >Female</option>
                        <option value="3" {{ $user->gender=='3' ? 'selected':''}} >Other</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12">
                    <a class="btn btn-custom-yellow btn-default d-block">
                      <!-- <span class="align-middle">Save</span> -->
                      <button type="submit" class="align-middle" id="profile-save-btn">Save</button>
                    </a>
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
        format: 'dd-mm-yyyy',
        autoclose: true,
        orientation: "bottom left"
    });
});

</script>
@endsection
