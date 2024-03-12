<!-- start address modal -->
<div class="modal fade custom-modal" id="addressChangeModal" tabindex="-1" aria-labelledby="addressChangeModal"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content border-radius">
            <div class="modal-header border-0 align-items-stretch">
                <div>
                    <h1 class="modal-title mb-0 font-sebinomedium"> delivery address </h1>
                    <p class="text-muted-lead-1 mb-0"> You have a saved address in this location </p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0 pt-xxl-3">
                <form id="address-form">
                    @csrf
                    <div class="row">
                        <div class="col-xx-6 col-xl-6 col-lg-col-md-12 col-sm-12 col-12">
                            <div class="form-group prev-input-group custom-icon-input-group">
                    <span class="input-group-icon">
                      <img src="{{ asset('images/zipcode-svg.svg') }}" alt="zipcode" class="img-fluid svg" width="22"
                           height="16"/>
                    </span>
                                <input type="text" class="form-control form-control-icon ps-5" maxlength="10" placeholder="Zip Code" value="{{ $zipcode }}"
                                       name="zipcode" id="zipcode" required/>
                                <label id="zipcode-error" class="error" for="zipcode" style="display: none"></label>
                            </div>
                        </div>
                        <div class="col-xx-6 col-xl-6 col-lg-col-md-12 col-sm-12 col-12">
                            <div class="form-group prev-input-group custom-icon-input-group">
                    <span class="input-group-icon">
                      <img src="{{ asset('images/home-icon-svg.svg') }}" alt="home address" class="img-fluid svg"
                           width="19" height="18"/>
                    </span>
                                <input type="text" class="form-control form-control-icon ps-5" maxlength="10" placeholder="House Number"
                                       value="{{ $house_no }}" name="house_no" id="house_no" required/>
                            </div>
                        </div>
                        <div class="colxx-6 col-xl-6 col-lg-col-md-12 col-sm-12 col-12 form-group mb-0">
                            <!-- <a href="#" class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold w-100">Save</a> -->
                            <button type="submit"
                                    class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold w-100">Save
                            </button>
                        </div>
                    </div>
                </form>
                @if(count($addresses))
                    <div class="address-box">
                        <h1 class="modal-title mb-0 font-sebinomedium">My Address</h1>
                        <hr/>
                        <div class="row">
                            @foreach($addresses as $key => $add)
                                <?php
                                $addressText = 'Deliver Here';
                                $style = '';
                                if (session('address') == $add->id) {
                                    $addressText = 'Selected';
                                    $style = 'style=pointer-events:none;cursor:default';
                                }
                                ?>
                                <div class="col-xx-6 col-xl-6 col-lg-col-md-12 col-sm-12 col-12 mobile-mb-10"
                                     style="padding: 5px !important;"
                                     id="address-{{ $add->id }}">
                                    <div class="card card-body h-100 address-card active">
                                        <p>{{ $add->company_name }} {{ $add->house_no }}, {{ $add->street_name }}
                                            , {{ $add->city }} {{ $add->zipcode }}</p>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <a href="javascript:void(0);"
                                               class="btn btn-xs-sm btn-custom-yellow text-capitalize select-address-btn"
                                               {{ $style }} data-id="{{ $add->id }}">{{ $addressText }}</a>
                                            <a class="btn btn-custom-yellow btn-icon"
                                               onclick="deleteAddress({{ $add->id }})">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </a>
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
