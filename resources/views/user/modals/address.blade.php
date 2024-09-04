<!-- start address modal -->
<div class="modal fade custom-modal" id="addressChangeModal" tabindex="-1" aria-labelledby="addressChangeModal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content border-radius">
            <div class="modal-header border-0 align-items-stretch">
                <div>
                    <h1 class="modal-title mb-0">{{ trans('modal.address.title') }} </h1>
                    <p class="text-muted-lead-1 mb-0">{{ trans('modal.address.sub_title') }}</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0 pt-xxl-3">
                <form id="address-form"> @csrf
                    <div class="row">
                        <div class="col-xx-6 col-xl-6 col-lg-col-md-12 col-sm-12 col-12">
                            <div class="form-group prev-input-group custom-icon-input-group">
                                <span class="input-group-icon">
                                    <img src="{{ asset('images/zipcode-svg-up.svg') }}" alt="zipcode"
                                        class="img-fluid svg" width="22" height="16" />
                                </span>
                                <input type="text" class="form-control form-control-icon ps-5" maxlength="10"
                                    placeholder="{{ trans('modal.address.zipcode') }}" value="{{ $zipcode }}"
                                    name="zipcode" id="zipcode" required />
                                <label id="zipcode-error" class="error" for="zipcode" style="display: none"></label>
                            </div>
                        </div>
                        <div class="col-xx-6 col-xl-6 col-lg-col-md-12 col-sm-12 col-12">
                            <div class="form-group prev-input-group custom-icon-input-group">
                                <span class="input-group-icon">
                                    <img src="{{ asset('images/home-icon-svg-up.svg') }}" alt="home address"
                                        class="img-fluid svg" width="19" height="18" />
                                </span>
                                <input type="text" class="form-control form-control-icon ps-5" maxlength="10"
                                    placeholder="{{ trans('modal.address.house_no') }}" value="{{ $house_no }}"
                                    name="house_no" id="house_no" required />
                            </div>
                        </div>
                        <div class="colxx-6 col-xl-6 col-lg-col-md-12 col-sm-12 col-12 form-group mb-0">
                            <button type="submit"
                                class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold w-100">{{ trans('modal.button.save') }}</button>
                        </div>
                    </div>
                </form>
                @if (count($addresses))
                    <div class="address-box">
                        <h1 class="modal-title mb-2 font-sebinomedium" style="margin-top: 20px !important;">
                            {{ trans('modal.address.my_address') }}</h1>
                        {{-- <hr /> --}}
                        <div class="row" id="addresses-length">
                            @foreach ($addresses as $key => $add)
                                <?php
                                $addressText = trans('modal.address.deliver_here');
                                $style = '';
                                $selectedAddress = '<span class="success-ico blank"></span>';
                                $selected = false;

                                if (session('address') == $add->id) {
                                    $selected = true;

                                    $addressText = 'Selected';
                                    $selectedAddress = '<span class="success-ico"><img src="' . asset("images/success-icon.svg") . '" class="svg" width="14" height="11"></span>';
                                    $style = 'style=pointer-events:none;cursor:default';
                                }
                                ?>
                                <div class="col-xx-6 col-xl-6 col-lg-col-md-12 col-sm-12 col-12 mobile-mb-10 mt-2 total-addresses mb-3"  id="address-{{ $add->id }}">
                                    <div class="card card-body h-100 address-card address-card-ui">
                                        <div class="d-flex  justify-content-start align-items-center">
                                            <a href="javascript:void(0);" class="position-relative d-flex select-address-btn selected-address" id="selected-address-{{ $add->id }}" data-selected-address="{{session('address')}}">
                                                {!! $selectedAddress !!}
                                            </a>
                                            <p class="mb-0 ps-3">{{ $add->company_name }} {{ $add->house_no }},
                                                {{ $add->street_name }} <br/>{{ $add->city }} {{ $add->zipcode }}</p>
                                            <div class="d-flex align-items-center justify-content-end ps-3 align-items-center ms-auto">
                                                {{-- <a href="javascript:void(0);" class="btn btn-xs-sm btn-custom-yellow text-capitalize select-address-btn" {{ $style }} data-id="{{ $add->id }}">{{ $addressText }}</a> --}}
                                         

                                                @if(count($addresses) > 1)
                                                    <a class="btn-icon ms-2 p-2 delete-address {{ $selected  == true ? 'd-none' : '' }}" onclick="deleteAddress({{ $add->id }})">
                                                        <i class="fa-regular fa-trash-can"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- end address modal -->
